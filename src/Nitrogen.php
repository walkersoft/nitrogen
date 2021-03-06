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
use Nitrogen\Framework\Core\ApplicationRunner;
use Nitrogen\Framework\Core\DependencySetupAssistant;
use Nitrogen\Framework\Core\RoutingSetupAssistant;
use Nitrogen\Interfaces\DependencyRepositoryAwareInterface;
use Nitrogen\Interfaces\RunnableInterface;

class Nitrogen extends ConfigurableContainer implements
    DependencyRepositoryAwareInterface,
    RunnableInterface
{

    /**
     * A dependency resolver.
     *
     * This is used by Nitrogen to instantiate various classes that have not
     * been overridden by an application.
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
     */
    public function __construct(DependencyRepositoryInterface $resolver = null)
    {
        parent::__construct();

        if ($resolver === null)
        {
            $resolver = new DependencyRepository();
        }

        $this->setResolver($resolver);
        $this->configureDefaultOptions();
    }

    /**
     * Executes the framework.
     */
    public function run()
    {
        $runner = $this->resolver->resolve('\Nitrogen\Framework\Core\ApplicationRunner', [$this]);
        $runner->run();
    }

    /**
     * Returns the routing agent, e.g. the object used to create routes.
     *
     * @return \Fusion\Router\Interfaces\RouteGroupInterface
     */
    public function getRouting()
    {
        if ($this->routing === null && $this->has('component.routing'))
        {
            $this->routing = $this->resolver->resolve($this['component.routing']);
        }

        return $this->routing;
    }

    /**
     * Sets default options for Nitrogen.
     *
     * Injects values into the container that will be used throughout the
     * framework to dictate various behaviors.
     */
    protected function configureDefaultOptions()
    {
        //Define bindings class for Fusion components and protect the entry
        $this->set('nitrogen.bindings', '\Nitrogen\Framework\Config\Bindings', true);
        $this->set('nitrogen.routes', '\Nitrogen\Framework\Config\Routes', true);

        //Define default classes for components that Nitrogen may end up using
        //These can be overridden.
        $this['component.router'] = '\Fusion\Router\Router';
        $this['component.routing'] = '\Fusion\Router\RouteGroup';
        $this['component.dependency-assistant'] = '\Nitrogen\Framework\Core\DependencySetupAssistant';
        $this['component.routing-assistant'] = '\Nitrogen\Framework\Core\RoutingSetupAssistant';

        //Define bindings needed before application runner has a chance to
        //setup the dependency assistant
        $this->resolver->bindInstance(
            '\Nitrogen\Framework\Core\DependencySetupAssistant',
            new DependencySetupAssistant($this)
        );

        $this->resolver->bindInstance(
            '\Nitrogen\Framework\Core\RoutingSetupAssistant',
            new RoutingSetupAssistant($this)
        );

        $this->resolver->bindCallback(
            '\Nitrogen\Framework\Core\ApplicationRunner',
            function ($app)
            {
                return new ApplicationRunner($app);
            }
        );
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
}