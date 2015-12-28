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
    }

    /**
     * Sets default options for Nitrogen.
     *
     * Injects values into the container that will be used throughout the
     * framework to dictate various behaviors.
     */
    protected function configureDefaultOptions()
    {
        //Define configuration classes
        $this['config.repository-bindings'] = '\Nitrogen\Framework\Core\Repository';

        //Define default component classes
        $this['component.server-request'] = '\Fusion\Http\ServerRequestFactory';
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