<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/30/2015
 * Time: 1:00 PM
 */

namespace Nitrogen\Framework\Core;

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

    /**
     * Dependency Setup Assistant
     *
     * @var \Nitrogen\Framework\Core\DependencySetupAssistant
     */
    protected $dependencyAssistant = null;

    /**
     * Routing Setup Assistant
     *
     * @var \Nitrogen\Framework\Core\RoutingSetupAssistant
     */
    protected $routingAssistant = null;

    /**
     * ApplicationRunner constructor.
     *
     * @param Nitrogen $app
     * @param \Nitrogen\Framework\Core\DependencySetupAssistant $dependencyAssistant
     * @param \Nitrogen\Framework\Core\RoutingSetupAssistant $routingAssistant
     */
    public function __construct(
        Nitrogen $app,
        DependencySetupAssistant $dependencyAssistant = null,
        RoutingSetupAssistant $routingAssistant = null
    )
    {
        $this->app = $app;
        $this->dependencyAssistant = $dependencyAssistant;
        $this->routingAssistant = $routingAssistant;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->applyBindings();
    }

    /**
     * Sets up dependencies needed by the framework and application.
     */
    protected function applyBindings()
    {
        if ($this->dependencyAssistant === null)
        {
            if ($this->app->has('nitrogen.dependency-assistant'))
            {
                $resolver = $this->app->getResolver();
                $this->dependencyAssistant = $resolver->resolve($this->app->get('nitrogen.dependency-assistant'));
            }
            else
            {
                $this->dependencyAssistant = new DependencySetupAssistant($this->app);
            }
        }

        if (!$this->dependencyAssistant instanceof DependencySetupAssistant)
        {
            throw new \RuntimeException(
                sprintf(
                    'Resolved dependency assistance must be type of DependencySetupAssistant. % given.',
                    gettype($this->dependencyAssistant) === 'object'
                        ? get_class($this->dependencyAssistant)
                        : gettype($this->dependencyAssistant)
                )
            );
        }

        $this->dependencyAssistant->run();
    }

    protected function applyRouting(RouteBindingsInterface $bindings)
    {
        //$bindings($this->app->getResolver()->resolve($this->app['nitrogen.routing']));
    }
}