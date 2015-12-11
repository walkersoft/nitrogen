<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/11/2015
 * Time: 1:35 PM
 */

namespace Nitrogen\Interfaces;


use Fusion\Container\Interfaces\DependencyResolverInterface;

interface DependencyResolverProxyInterface extends DependencyResolverInterface
{
    /**
     * Sets a `DependencyResolverInterface` instance.
     *
     * Allows a class implementing this interface to obtain a new dependency
     * resolver from client code.
     *
     * @param \Fusion\Container\Interfaces\DependencyResolverInterface $resolver
     * @return self
     */
    public function setResolver(DependencyResolverInterface $resolver);

    /**
     * Gets the current `DependencyResolverInterface` instance.
     *
     * Allows a class implementing this interface to expose currently dependency
     * resolver being used.
     *
     * @return \Fusion\Container\Interfaces\DependencyResolverInterface
     */
    public function getResolver();
}