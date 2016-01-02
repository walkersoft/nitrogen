<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/29/2015
 * Time: 9:10 AM
 */

namespace Nitrogen\Framework\Config;

use Fusion\Container\Interfaces\DependencyRepositoryInterface;
use Fusion\Http\ServerRequestFactory;
use Nitrogen\Interfaces\DependencyBindingsInterface;

class Bindings implements DependencyBindingsInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(DependencyRepositoryInterface $resolver)
    {
        /*
         * Routing bindings
         */
        $resolver->bindContract(
            '\Fusion\Router\Interfaces\RouteGroupInterface',
            '\Fusion\Router\RouteGroup'
        );
        $resolver->bindContract(
            '\Fusion\Router\Interfaces\RouteInterface',
            '\Fusion\Router\Route'
        );
        $resolver->bindContract(
            '\Fusion\Router\Interfaces\RoutePatternParserInterface',
            '\Fusion\Router\RoutePatternParser'
        );
        $resolver->bindContract(
            '\Fusion\Router\Interfaces\RouteStoreInterface',
            '\Fusion\Router\RouteStore'
        );
        $resolver->bindCallback(
            '\Fusion\Router\Interfaces\RouterInterface',
            function () use ($resolver)
            {
                return $resolver->resolve('\Fusion\Router\Router');
            }
        );
        $resolver->bindContract(
            '\Fusion\Router\Interfaces\RouteFactoryInterface',
            '\Fusion\Router\RouteFactory'
        );
        $resolver->bindCallback(
            '\Fusion\Router\Interfaces\RouteGroupInterface',
            function () use ($resolver)
            {
                return $resolver->resolve('\Fusion\Router\RouteGroup');
            }
        );

        /*
         * Payload bindings
         */
        $resolver->bindContract(
            '\Fusion\Payload\Interfaces\DomainPayloadInterface',
            '\Fusion\Payload\DomainPayload'
        );
        $resolver->bindContract(
            '\Fusion\Payload\Interfaces\PayloadInterface',
            '\Fusion\Payload\Payload'
        );

        /*
         * PSR-7 bindings
         */
        $resolver->bindContract(
            '\Psr\Http\Message\ResponseInterface',
            '\Fusion\Http\Response'
        );
        $resolver->bindCallback(
            '\Psr\Http\Message\ServerRequestInterface',
            function ()
            {
                return (new ServerRequestFactory())->makeServerRequest();
            }
        );

        /*
         * Collection bindings
         */
        $resolver->bindContract(
            '\Fusion\Collection\CollectionInterface',
            '\Fusion\Collection\Collection'
        );
        $resolver->bindContract(
            '\Fusion\Collection\TraversableCollectionInterface',
            '\Fusion\Collection\TraversableCollection'
        );

        /*
         * Nitrogen component bindings
         */
        $resolver->bindContract(
            '\Nitrogen\Interfaces\ActionDispatcherInterface',
            '\Nitrogen\Framework\ActionDispatcher'
        );
        $resolver->bindContract(
            '\Nitrogen\Interfaces\ResponderDispatcherInterface',
            '\Nitrogen\Framework\ResponderDispatcher'
        );
    }
}