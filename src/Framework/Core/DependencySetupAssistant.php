<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 1/1/2016
 * Time: 12:18 PM
 */

namespace Nitrogen\Framework\Core;


use Nitrogen\Interfaces\DependencyBindingsInterface;
use Nitrogen\Interfaces\RunnableInterface;
use Nitrogen\Nitrogen;

class DependencySetupAssistant implements RunnableInterface
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
        $this->configureDependencyBindings();
    }

    /**
     * Configures dependency bindings set by the framework and application.
     *
     * This method looks for two different keys SHOULD already be set by the
     * application.  One is `nitrogen.bindings`, which is the default bindings
     * set by the framework, and the other is `app.bindings` which is defined
     * by the application if necessary.
     *
     * Both keys MUST be a string with fully qualified class name of a class
     * that implements the `DependencyBindingsInterface`. If a non-string value
     * is given the dependency resolver (which will be responsible for loading
     * the classes) will throw an exception.
     */
    protected function configureDependencyBindings()
    {
        $bindings = [];

        //Get bindings set by the framework. This key SHOULD already exist, but
        //check for it anyhow.
        if ($this->app->has('nitrogen.bindings'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('nitrogen.bindings'))
            );
        }

        //Get bindings set by the application. This key might not exist so it
        //MUST by checked to ensure it exists.
        if ($this->app->has('app.bindings'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('app.bindings'))
            );
        }

        //Cycle the bindings and type check results to make sure classes where
        //resolved are `DependencyBindingsInterface` implementations.
        foreach($bindings as $binding)
        {
            if ($binding instanceof DependencyBindingsInterface)
            {
                $binding($this->app->getResolver());
            }
        }
    }
}