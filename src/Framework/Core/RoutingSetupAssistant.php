<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 1/1/2016
 * Time: 12:37 PM
 */

namespace Nitrogen\Framework\Core;

use Nitrogen\Interfaces\RouteBindingsInterface;
use Nitrogen\Interfaces\RunnableInterface;
use Nitrogen\Nitrogen;

class RoutingSetupAssistant implements RunnableInterface
{

    /**
     * Route group.
     *
     * @var \Nitrogen\Nitrogen
     */
    protected $app;

    /**
     * RoutingSetupAssistant constructor.
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
        $this->configureApplicationRoutes();
    }

    /**
     * Configures routes set by the framework and application.
     *
     * This method looks for two different keys SHOULD already be set by the
     * application.  One is `nitrogen.routes`, which is the default bindings
     * set by the framework, and the other is `app.routes` which is defined
     * by the application if necessary.
     *
     * Both keys MUST be a string with fully qualified class name of a class
     * that implements the `RoutingBindingsInterface`. If a non-string value
     * is given the dependency resolver (which will be responsible for loading
     * the classes) will throw an exception.
     */
    protected function configureApplicationRoutes()
    {
        $bindings = [];

        //Get bindings set by the framework. This key SHOULD already exist, but
        //check for it anyhow.
        if ($this->app->has('nitrogen.routes'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('nitrogen.routes'))
            );
        }

        //Get bindings set by the application. This key might not exist so it
        //MUST by checked to ensure it exists.
        if ($this->app->has('app.routes'))
        {
            array_push(
                $bindings,
                $this->app->getResolver()->resolve($this->app->get('app.routes'))
            );
        }

        //Get the routing
        $routing = $this->app->getRouting();

        //Cycle the bindings and type check results to make sure classes where
        //resolved are `DependencyBindingsInterface` implementations.
        foreach($bindings as $binding)
        {
            if ($binding instanceof RouteBindingsInterface)
            {
                $binding($routing);
            }
        }
    }
}
