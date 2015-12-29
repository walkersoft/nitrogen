<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/11/2015
 * Time: 1:35 PM
 */

namespace Nitrogen\Interfaces;

use Fusion\Container\Interfaces\DependencyRepositoryInterface;

interface DependencyRepositoryAwareInterface
{
    /**
     * Sets a `DependencyResolverInterface` instance.
     *
     * Allows a class implementing this interface to obtain a new dependency
     * resolver from client code.
     *
     * @param \Fusion\Container\Interfaces\DependencyRepositoryInterface $resolver
     * @return self
     */
    public function setResolver(DependencyRepositoryInterface $resolver);

    /**
     * Gets the current `DependencyResolverInterface` instance.
     *
     * Allows a class implementing this interface to expose currently dependency
     * resolver being used.
     *
     * @return \Fusion\Container\Interfaces\DependencyRepositoryInterface
     */
    public function getResolver();
}