<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/30/2015
 * Time: 1:00 PM
 */

namespace Nitrogen\Framework\Core;


use Nitrogen\Interfaces\DependencyBindingsInterface;
use Nitrogen\Interfaces\RouteBindingsInterface;
use Nitrogen\Interfaces\RunnableInterface;
use Nitrogen\Nitrogen;

class ApplicationRunner implements RunnableInterface
{
    /**
     * The application instance.
     *
     * @var \Nitrogen\Nitrogen
     */
    protected $app = null;

    public function __construct(Nitrogen $app)
    {
        $this->app = $app;
    }

    /**
     * Instructs the object to perform its "run" routine.
     */
    public function run()
    {
        // TODO: Implement run() method.
    }

    /**
     * Invokes a `Bindings` object with a resolver.
     *
     * @param \Nitrogen\Interfaces\DependencyBindingsInterface $bindings
     */
    protected function applyBindings(DependencyBindingsInterface $bindings)
    {
        $bindings($this->app->getResolver());
    }

    protected function getDependencyBindings()
    {
        $bindings = [];

        //Apply all bindings
        if ($this->app->has('nitrogen.bindings'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('nitrogen.bindings'))
            );
        }

        if ($this->app->has('app.bindings'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('app.bindings'))
            );
        }

        foreach($bindings as $binding)
        {
            if ($binding instanceof DependencyBindingsInterface)
            {
                $this->applyBindings($binding);
            }
        }
    }

    protected function applyRouting(RouteBindingsInterface $bindings)
    {
        //$bindings($this->app->getResolver()->resolve($this->app['nitrogen.routing']));
    }
}