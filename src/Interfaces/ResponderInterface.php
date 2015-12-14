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
     *
     * @param array $data Optional data that can be used by the responder.
     */
    public function __invoke(array $data = []);

    /**
     * Sets a PSR-7 `ResponseInterface` in the responder.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return self
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Returns the PSR-7 `ResponseInterface` object.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \RuntimeException If response has not been set.
     */
    public function getResponse();

    /**
     * Sets an instance of a `ViewInterface` in the responder.
     *
     * @param \Nitrogen\Interfaces\ViewInterface $view
     * @return self
     */
    public function setView(ViewInterface $view);

    /**
     * Returns a `ViewInterface` instance.
     *
     * @return \Nitrogen\Interfaces\ViewInterface
     * @throws \RuntimeException If the view has not been set.
     */
    public function getView();

    /**
     * Sets a `PayloadInterface` instance in the responder.
     *
     * @param \Fusion\Payload\Interfaces\PayloadInterface
     * @return self
     */
    public function setPayload(PayloadInterface $payload);

    /**
     * Returns the `PayloadInterface` instance.
     *
     * @return \Fusion\Payload\Interfaces\PayloadInterface
     * @throws \RuntimeException If the payload has not been set.
     */

    public function getPayload();
}