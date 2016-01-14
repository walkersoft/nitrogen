<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 1/14/2016
 * Time: 9:28 AM
 */

namespace Nitrogen\Framework\Core;


use Fusion\Http\Interfaces\ResponseTransmitterInterface;
use Nitrogen\Interfaces\ResponderInterface;
use Nitrogen\Interfaces\RunnableInterface;
use Nitrogen\Nitrogen;
use Psr\Http\Message\ResponseInterface;

class ResponderDispatcher implements RunnableInterface
{

    /**
     * A Responder instance
     *
     * @var \Nitrogen\Interfaces\ResponderInterface
     */
    protected $responder = null;


    /**
     * ResponderDispatcher constructor.
     *
     * @param \Nitrogen\Interfaces\ResponderInterface $responder
     *
     * @internal param \Nitrogen\Nitrogen $app
     * @internal param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponderInterface $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Instructs the object to perform its "run" routine.
     */
    public function run()
    {
        return $this->responder->getResponse();
    }
}