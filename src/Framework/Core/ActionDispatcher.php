<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 1/8/2016
 * Time: 2:22 PM
 */

namespace Nitrogen\Framework\Core;

use Fusion\Router\Interfaces\RouteInterface;
use Fusion\Router\Interfaces\RouterInterface;
use Nitrogen\Interfaces\ActionInterface;
use Nitrogen\Interfaces\ResponderInterface;
use Nitrogen\Interfaces\RunnableInterface;
use Nitrogen\Nitrogen;
use Psr\Http\Message\ServerRequestInterface;

class ActionDispatcher implements RunnableInterface
{
    /**
     * Nitrogen application
     * @var \Nitrogen\Nitrogen
     */
    protected $app = null;

    /**
     * ActionDispatcher constructor.
     *
     * @param \Nitrogen\Nitrogen $app
     */
    public function __construct(Nitrogen $app)
    {
        $this->app = $app;
    }

    /**
     * Runs the dispatcher ultimately returning a `ResponderInterface` instance.
     *
     * @return \Nitrogen\Interfaces\ResponderInterface
     */
    public function run()
    {
        $resolver = $this->app->getResolver();

        $route = $this->getMatchedRoute(
            $resolver->resolve('\Psr\Http\Message\ServerRequestInterface'),
            $resolver->resolve('\Fusion\Router\Interfaces\RouterInterface')
        );

        return $this->dispatch($this->getAction($route), $route);
    }

    /**
     * Uses a Request and Router implementation to return a matched route.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Fusion\Router\Interfaces\RouterInterface $router
     * @return \Fusion\Router\Interfaces\RouteInterface
     */
    protected function getMatchedRoute(ServerRequestInterface $request, RouterInterface $router)
    {
        $target = $request->getUri()->getPath();
        $method = $request->getMethod();
        $route = $router->match($target, $method);

        return $route;
    }

    /**
     * Gets the action from the matched route.
     *
     * This method with throw an exception when a retrieved action is invalid.
     * In order to be valid an action MUST be a string, a callable or an
     * implementation of the `\Nitrogen\Interfaces\ActionInterface` interface.
     *
     * @param \Fusion\Router\Interfaces\RouteInterface $route
     * @return \Nitrogen\Interfaces\ActionInterface|string|callable
     * @throws \RuntimeException When `$action` is not an valid action.
     */
    protected function getAction(RouteInterface $route)
    {
        $action = $route->getAction();

        if(!$action instanceof ActionInterface && !is_string($action) && !is_callable($action))
        {
            throw new \RuntimeException(
                sprintf(
                    'Action must be a string, callable or instance of ActionInterface. %s given.',
                    is_object($action) ? get_class($action) : gettype($action)
                )
            );
        }

        return $action;
    }

    /**
     * Dispatches a given action based on the action type.
     *
     * This method with accept an action based off of a few different action
     * types and then invoke the action.
     *
     * The following action types are acceptable:
     *
     * - An object implementing the `ActionInterface` interface.
     * - A string of a FCQN that implements the `ActionInterface` interface.
     * - A closure that returns a `ResponderInterface` implementation.
     *
     * When an object is given it MUST implement the `ActionInterface` interface.
     * The object is then sent to the `dispatchAsAction()` method.
     *
     * When a string is given the system will attempt to resolve a class as
     * if the string were the FQCN using the `dispatchAsString()` which will in
     * turn send it to be executed using the `dispatchAsAction()` method.
     *
     * When a closure is given the closure is invoked and certain parameters are
     * passed to the closure.  The system will listen for the callable to return
     * an implementation of `ResponderInterface` in order to continue.
     *
     * This method MUST thrown an exception when an implementation of the
     * `ResponderInterface` interface is not obtainable.
     *
     * @param \Nitrogen\Interfaces\ResponderInterface|string|callable $action
     * @param \Fusion\Router\Interfaces\RouteInterface $route
     * @return \Nitrogen\Interfaces\ResponderInterface|null
     */
    protected function dispatch($action, RouteInterface $route)
    {
        if (!$action instanceof ResponderInterface && !is_string($action) && !is_callable($action))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Action must be a string, callable or ActionInterface instance. % given.',
                    is_object($action) ? get_class($action) : gettype($action)
                )
            );
        }

        $responder = null;

        if (is_string($action))
        {
            if($this->app->has('app.action-namespace'))
            {
                $action = $this->app->get('app.action-namespace') . $action;
            }

            $responder = $this->dispatch($this->dispatchAsString($action), $route);
        }

        if (is_callable($action) && !$action instanceof ActionInterface)
        {
            $responder = $this->dispatchAsCallable($action, $route);
        }

        if ($action instanceof ActionInterface)
        {
            $responder = $this->dispatchAsAction($action, $route);
        }

        return $responder;

    }

    /**
     * Resolves an action from the FQCN given as a string.
     *
     * @param string $action
     * @return \Nitrogen\Interfaces\ActionInterface|callable
     */
    protected function dispatchAsString($action)
    {
        $action = $this->app->getResolver()->resolve($action);

        if(!$action instanceof ActionInterface && !is_callable($action))
        {
            throw new \RuntimeException(
                sprintf(
                    'Resolved action must be a callable or ActionInterface instance. %s given.',
                    is_object($action) ? get_class($action) : gettype($action)
                )
            );
        }

        return $action;
    }

    /**
     * Dispatches a callable action.
     *
     * This method will invoke a callable action and inject certain parameters
     * into the closure for use in the domain layer.
     *
     * A closure action MUST return an instance of the `ResponderInterface`
     * interface or this method will throw an exception.
     *
     * @param callable $action
     * @param \Fusion\Router\Interfaces\RouteInterface $route
     * @throws \RuntimeException When the callable doesn't return a
     *     `ResponderInterface` instance.
     */
    protected function dispatchAsCallable(callable $action, RouteInterface $route)
    {
        $payload = $this->app->getResolver()->resolve('\Fusion\Payload\Interfaces\DomainPayloadInterface');
        $payload->setItem('matched-route', $route);

        $responder = $action(['payload' => $payload]);

        if(!$responder instanceof ResponderInterface)
        {
            throw new \RuntimeException(
                'Invokable callback actions must return an instance of ResponderInterface.'
            );
        }

        return $responder;
    }

    /**
     * Dispatches an `ActionInterface` instance.
     *
     * @param \Nitrogen\Interfaces\ActionInterface $action
     * @param \Fusion\Router\Interfaces\RouteInterface $route
     * @return \Nitrogen\Interfaces\ResponderInterface
     */
    protected function dispatchAsAction(ActionInterface $action, RouteInterface $route)
    {
        $payload = $action->getDomainPayload();
        $payload->setItem('matched-route', $route);

        $responder = $action();

        if(!$responder instanceof ResponderInterface)
        {
            $responder = $action->getResponder();
        }

        return $responder;
    }
}