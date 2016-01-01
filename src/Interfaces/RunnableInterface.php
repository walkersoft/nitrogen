<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/30/2015
 * Time: 1:09 PM
 */

namespace Nitrogen\Interfaces;


interface RunnableInterface
{
    /**
     * Instructs the object to perform its "run" routine.
     */
    public function run();
}