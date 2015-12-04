<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 12:46 PM
 */

namespace Nitrogen\Interfaces;


interface ViewInterface
{
    /**
     * Causes a view to _render_ itself into output for the client.
     *
     * @return mixed The rendered output.
     */
    public function render();
}