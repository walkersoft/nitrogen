<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/30/2015
 * Time: 3:03 PM
 */

namespace Nitrogen\Interfaces;

use Fusion\Router\Interfaces\RouteGroupInterface;

interface RouteBindingsInterface
{
    public function __invoke(RouteGroupInterface $routes);
}