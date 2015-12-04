<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:34 AM
 */

namespace Nitrogen\Interfaces;

use Fusion\Payload\Interfaces\PayloadInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
    /**
     * Invoke the responder.
     *
     * The method SHOULD ultimately call the view system for a request to
     * generate the output that will effectively be sent back to the client.
     */
    public function __invoke();

    /**
     * Sets a PSR-7 `ResponseInterface` in the responder.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Sets an instance of a `ViewInterface` in the responder.
     *
     * @param \Nitrogen\Interfaces\ViewInterface $view
     */
    public function setView(ViewInterface $view);

    /**
     * Sets a `PayloadInterface` instance in the responder.
     *
     * @param \Fusion\Payload\Interfaces\PayloadInterface
     */
    public function setPayload(PayloadInterface $payload);
}