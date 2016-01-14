<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 1/1/2016
 * Time: 4:01 PM
 */

namespace Nitrogen\Framework\Config;


use Fusion\Router\Interfaces\RouteGroupInterface;
use Nitrogen\Interfaces\RouteBindingsInterface;

class Routes implements RouteBindingsInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(RouteGroupInterface $routes)
    {
        $routes->setDefaultMethods(['GET']);
    }
}