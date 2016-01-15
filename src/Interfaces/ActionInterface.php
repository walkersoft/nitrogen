<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:34 AM
 */

namespace Nitrogen\Interfaces;

use Fusion\Payload\Interfaces\DomainPayloadInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * MUST return null.
     *
     * @return \Nitrogen\Interfaces\ResponderInterface|null
     */
    public function __invoke();

    /**
     * Sets a PSR-7 `ServerRequestInterface` instance in the action.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return self
     */
    public function setRequest(ServerRequestInterface $request);

    /**
     * Gets the current `ServerRequestInterface` instance.
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     * @throws \RuntimeException If the request has not been set.
     */
    public function getRequest();

    /**
     * Sets a `ResponderInterface` instance.
     *
     * @param \Nitrogen\Interfaces\ResponderInterface $responder
     *
     * @return self
     */
    public function setResponder(ResponderInterface $responder);

    /**
     * Gets the current `ResponderInterface` instance.
     *
     * @return \Nitrogen\Interfaces\ResponderInterface
     * @throws \RuntimeException If the responder has not been set.
     */
    public function getResponder();

    /**
     * Sets a `DomainPayloadInterface` instance in the action.
     *
     * A `DomainPayload` is a special object used to capture data from the domain
     * layer of an application. Typically this will be information about a domain
     * operation and any result information.
     *
     * @param \Fusion\Payload\Interfaces\DomainPayloadInterface $payload
     *
     * @return self
     */
    public function setDomainPayload(DomainPayloadInterface $payload);

    /**
     * Gets the current `DomainPayloadInterface` instance.
     *
     * @return \Fusion\Payload\Interfaces\DomainPayloadInterface
     * @throws \RuntimeException When a domain payload has not been set.
     */
    public function getDomainPayload();
}