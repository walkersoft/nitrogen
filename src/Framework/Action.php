<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/14/2015
 * Time: 2:05 PM
 */

namespace Nitrogen\Framework;

use Fusion\Http\ServerRequestFactory;
use Fusion\Payload\DomainPayload;
use Fusion\Payload\Interfaces\DomainPayloadInterface;
use Nitrogen\Framework\Core\AbstractAction;
use Nitrogen\Framework\Responder;
use Nitrogen\Interfaces\ResponderInterface;
use Psr\Http\Message\ServerRequestInterface;

class Action extends AbstractAction
{

    /**
     * Constructor.
     *
     * The intent of this class is to provide a default implementation that
     * will instantiate the main parts of the action and also a default (albiet
     * useless) implementation of the `__invoke()` method.
     *
     * If this constructor is suitable for a particular action then it is
     * RECOMMENDED that clients extend this class and override the `__invoke()`
     * method with a domain-specific implementation otherwise it may be more
     * beneficial to extend the `AbstractAction` class or implement the
     * `ActionInterface` interface instead.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Fusion\Payload\Interfaces\DomainPayloadInterface $payload
     * @param \Nitrogen\Interfaces\ResponderInterface $responder
     */
    public function __construct(
        ServerRequestInterface $request = null,
        DomainPayloadInterface $payload = null,
        ResponderInterface $responder = null
    )
    {
        $request = $request === null
            ? (new ServerRequestFactory())->makeServerRequest()
            : $request;

        $payload = $payload === null
            ? new DomainPayload()
            : $payload;

        $responder = $responder === null
            ? new Responder()
            : $responder;

        $this->setRequest($request);
        $this->setDomainPayload($payload);
        $this->setResponder($responder);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(array $data = [])
    {
        //This method will not provide any meaningful implementation
        //But a class inheriting it will (or at least should)
        $this->payload->setSuggestedResponseCode(417);
    }
}