<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/4/2015
 * Time: 10:33 AM
 */

namespace Nitrogen\Framework\Core;

use Fusion\Payload\Interfaces\PayloadInterface;
use Nitrogen\Interfaces\ResponderInterface;
use Nitrogen\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponder implements ResponderInterface
{
    /**
     * HTTP response.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response = null;

    /**
     * Payload instance.
     *
     * @var \Fusion\Payload\Interfaces\PayloadInterface
     */
    protected $payload = null;

    /**
     * View system.
     *
     * @var \Nitrogen\Interfaces\ViewInterface
     */
    protected $view = null;

    /**
     * Sets a PSR-7 `ResponseInterface` instance in the responder.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return self
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Returns the PSR-7 `ResponseInterface` instance.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \RuntimeException If response has not been set.
     */
    public function getResponse()
    {
        if(!$this->response instanceof ResponseInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the response - the data is invalid or missing.'
            );
        }

        return $this->response;
    }

    /**
     * Sets an instance of a `ViewInterface` in the responder.
     *
     * @param \Nitrogen\Interfaces\ViewInterface $view
     * @return self
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Returns the `ViewInterface` instance.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \RuntimeException If response has not been set.
     */
    public function getView()
    {
        if(!$this->view instanceof ViewInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the view - the data is invalid or missing.'
            );
        }

        return $this->response;
    }

    /**
     * Sets a `PayloadInterface` instance in the responder.
     *
     * @param \Fusion\Payload\Interfaces\PayloadInterface
     * @return self
     */
    public function setPayload(PayloadInterface $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Returns the `PayloadInterface` instance.
     *
     * @return \Fusion\Payload\Interfaces\PayloadInterface
     * @throws \RuntimeException If payload has not been set.
     */
    public function getPayload()
    {
        if(!$this->payload instanceof PayloadInterface)
        {
            throw new \RuntimeException(
                'Unable to retrieve the payload - the data is invalid or missing.'
            );
        }

        return $this->response;
    }
}