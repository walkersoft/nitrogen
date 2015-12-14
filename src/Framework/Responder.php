<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/14/2015
 * Time: 2:31 PM
 */

namespace Nitrogen\Framework;

use Fusion\Http\Response;
use Fusion\Payload\DomainPayload;
use Fusion\Payload\Interfaces\PayloadInterface;
use Fusion\Payload\Payload;
use Nitrogen\Framework\Core\AbstractResponder;
use Nitrogen\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseInterface;

class Responder extends AbstractResponder
{

    /**
     * Constructor.
     *
     * The intent of this class is to provide a default implementation that
     * will instantiate the main parts of the responder and also a default
     * (albiet useless) implementation of the `__invoke()` method.
     *
     * If this constructor is suitable for a particular responder then it is
     * RECOMMENDED that clients extend this class and override the `__invoke()`
     * method with a domain-specific implementation otherwise it may be more
     * beneficial to extend the `AbstractResponder` class or implement the
     * `ResponderInterface` interface instead.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Fusion\Payload\Interfaces\PayloadInterface $payload
     * @param \Nitrogen\Interfaces\ViewInterface $view
     */
    public function __construct(
        ResponseInterface $response,
        PayloadInterface $payload,
        ViewInterface $view
    )
    {
        $payload = $payload === null
            ? new Payload(new DomainPayload())
            : $payload;

        $response = $response === null
            ? new Response()
            : $response;

        $view = $view === null
            ? new View()
            : $view;

        $this->setResponse($response);
        $this->setPayload($payload);
        $this->setView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(array $data = [])
    {
        return $this->view->render();
    }
}