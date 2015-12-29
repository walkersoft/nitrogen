<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:13 AM
 */

namespace Nitrogen;

use Fusion\Container\ConfigurableContainer;
use Fusion\Container\DependencyRepository;
use Fusion\Container\Interfaces\DependencyRepositoryInterface;
use Nitrogen\Framework\Config\Bindings;
use Nitrogen\Interfaces\DependencyRepositoryProxyInterface;

class Nitrogen extends ConfigurableContainer implements DependencyRepositoryProxyInterface
{

    /**
     * A dependency resolver.
     *
     * This is used by Nitrogen to instantiate various classes that have not
     * been overidden by an application.
     *
     * @var \Fusion\Container\Interfaces\DependencyRepositoryInterface
     */
    private $resolver = null;

    /**
     * The routing agent.
     *
     * In the context of Nitrogen the routing agent is an object that implements
     * the `\Fusion\Router\Interfaces\RouteGroupInterface` interface.
     *
     * @var \Fusion\Router\Interfaces\RouteGroupInterface
     */
    private $routing = null;

    /**
     * The router.
     *
     * In the context of Nitrogen the router is an object that implements the
     * `\Fusion\Router\Interfaces\RouterInterface`.
     *
     * The router itself SHOULD NOT be used as the mechanism to add routes by
     * client code that consumes the router.  Clients SHOULD use an implementation
     * of the `\Fusion\Router\Interfaces\RouteGroupInterface` which contains
     * all the helper methods to create and configure routes that are being stored
     * in the router.
     *
     * @var \Fusion\Router\Interfaces\RouterInterface
     */
    private $router = null;

    /**
     * Constructor.
     *
     * Accepts an implementation of the Fusion `DependencyRepositoryInterface` as
     * an optional argument or a default implementation will be created.
     *
     * @param \Fusion\Container\Interfaces\DependencyRepositoryInterface $resolver
     * @param \Nitrogen\Framework\Config\Bindings $bindings
     */
    public function __construct(
        DependencyRepositoryInterface $resolver = null,
        Bindings $bindings = null
    )
    {
        parent::__construct();

        if ($resolver === null)
        {
            $resolver = new DependencyRepository();
        }

        if ($bindings === null)
        {
            $bindings = new Bindings();
        }

        $this->setResolver($resolver);
        $this->configureDefaultOptions();
        $bindings($this->getResolver());
    }

    /**
     * Invokes a `Bindings` object with a resolver.
     *
     * @param Bindings $bindings
     */
    public function applyBindings(Bindings $bindings)
    {
        $bindings($this->getResolver());
    }

    /**
     * Returns the routing agent, e.g. the object used to create routes.
     *
     * @return \Fusion\Router\Interfaces\RouteGroupInterface
     */
    public function getRouting()
    {
        if ($this->routing === null)
        {
            $this->routing = $this->resolve($this['component.routing']);
        }

        return $this->routing;
    }

    /**
     * Returns the router implementation.
     *
     * @return \Fusion\Router\Interfaces\RouterInterface
     */
    protected function getRouter()
    {
        if ($this->router === null)
        {
            $this->router = $this->resolve($this['component.router']);
        }

        return $this->router;
    }

    /**
     * Sets default options for Nitrogen.
     *
     * Injects values into the container that will be used throughout the
     * framework to dictate various behaviors.
     */
    protected function configureDefaultOptions()
    {
        //Define default component classes
        $this['component.server-request'] = '\Psr\Http\Message\ServerRequestInterface';
        $this['component.router'] = '\Fusion\Router\Router';
        $this['component.routing'] = '\Fusion\Router\RouteGroup';
        $this['component.action-dispatcher'] = '\Nitrogen\Framework\ActionDispatcher';
        $this['component.responder-dispatcher'] = '\Nitrogen\Framework\ResponderDispatcher';
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($dependency, array $callbackArgs = [])
    {
        return $this->resolver->resolve($dependency, $callbackArgs);
    }

    /**
     * {@inheritdoc}
     */
    public function bindContract($contract, $class)
    {
        $this->resolver->bindContract($contract, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function bindInstance($dependency, $object)
    {
        $this->resolver->bindInstance($dependency, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function bindCallback($dependency, callable $callback)
    {
        $this->resolver->bindCallback($dependency, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(DependencyRepositoryInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function saveAll($save = true)
    {
        $this->resolver->saveAll($save);
    }

    /**
     * {@inheritdoc}
     */
    public function saveNext($class = true)
    {
        $this->resolver->saveNext($class);
    }
}