<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:13 AM
 */

namespace Nitrogen;

use Fusion\Container\DependencyResolver;
use Fusion\Container\Interfaces\DependencyResolverInterface;
use Nitrogen\Interfaces\DependencyResolverProxyInterface;

class Nitrogen implements DependencyResolverProxyInterface
{

    /**
     * A dependency resolver.
     *
     * This is used by Nitrogen to instantiate various classes that have not
     * been overidden by an application.
     *
     * @var \Fusion\Container\Interfaces\DependencyResolverInterface
     */
    private $resolver = null;

    /**
     * Constructor.
     *
     * Accepts an implementation of the Fusion `DependencyResolverInterface` as
     * an optional argument or a default implementation will be created.
     *
     * @param \Fusion\Container\Interfaces\DependencyResolverInterface $resolver
     */
    public function __construct(DependencyResolverInterface $resolver = null)
    {
        if ($resolver === null)
        {
            $resolver = new DependencyResolver();
        }

        $this->setResolver($resolver);
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
    public function setResolver(DependencyResolverInterface $resolver)
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