<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:34 AM
 */

namespace Nitrogen\Interfaces;


interface ActionInterface
{
    /**
     * Invoke the action.
     *
     * This method SHOULD ultimately trigger a domain operation (if applicable)
     * and return a configured `ResponderInterface` instance.
     *
     * Although this method may choose to invoke the responder directly, it
     * SHOULD return it to allow the client the opportunity to operate on it
     * if necessary.
     *
     * In the event this method invokes the responder directly then this method
     * MUST return nulll.
     *
     * @return \Nitrogen\Interfaces\ResponderInterface|null
     */
    public function __invoke();
}