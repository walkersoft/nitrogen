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
     * {@inheritdoc}
     */
    public function run()
    {
        $resolver = $this->app->getResolver();

        $route = $this->getMatchedRoute(
            $resolver->resolve('\Psr\Http\Message\ServerRequestInterface'),
            $resolver->resolve('\Fusion\Router\Interfaces\RouterInterface')
        );

        $this->dispatch($this->getAction($route));
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

    protected function dispatch($action) {}

    protected function dispatchAsString() {}

    protected function dispatchAsCallable() {}

    protected function dispatchAsAction() {}
}