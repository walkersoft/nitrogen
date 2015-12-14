<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:33 AM
 */

namespace Nitrogen\Framework\Core;

use Fusion\Payload\Interfaces\DomainPayloadInterface;
use Nitrogen\Interfaces\ActionInterface;
use Nitrogen\Interfaces\ResponderInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction implements ActionInterface
{
    /**
     * Server request.
     *
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request = null;

    /**
     * Domain payload.
     *
     * @var \Fusion\Payload\Interfaces\DomainPayloadInterface
     */
    protected $payload = null;

    /**
     * Responder.
     *
     * @var \Nitrogen\Interfaces\ResponderInterface
     */
    protected $responder = null;

    /**
     * {@inheritdoc}
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        if (!$this->request instanceof ServerRequestInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the request - the data is invalid or missing.'
            );
        }

        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponder(ResponderInterface $responder)
    {
        $this->responder = $responder;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponder()
    {
        if (!$this->responder instanceof ResponderInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the responder - the data is invalid or missing.'
            );
        }

        return $this->responder;
    }

    /**
     * {@inheritdoc}
     */
    public function setDomainPayload(DomainPayloadInterface $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomainPayload()
    {
        if (!$this->payload instanceof DomainPayloadInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the payload - the data is invalid or missing.'
            );
        }

        return $this->payload;
    }
}