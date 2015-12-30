<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/30/2015
 * Time: 10:22 AM
 */

namespace Nitrogen\Interfaces;


use Fusion\Container\Interfaces\DependencyRepositoryInterface;

interface DependencyBindingsInterface
{
    /**
     * Creates all bindings for the `DependencyRepositoryInterface` instance.
     *
     * This method MUST accept a `DependencyRepositoryInterface` instance.
     * Implementors of this method SHOULD use the `$resolver` object to bind all
     * needed contracts, instances and callbacks in this method.
     *
     * Implementors SHOULD NOT provide an instance for `$resolver` is the intention
     * is for the framework to wire in an instance that is already in use. This
     * will ensure the current dependency repository gets the bindings and will
     * properly load any bindings defined.
     *
     * @param \Fusion\Container\Interfaces\DependencyRepositoryInterface $resolver
     */
    public function __invoke(DependencyRepositoryInterface $resolver);
}