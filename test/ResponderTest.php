<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/14/2015
 * Time: 9:57 PM
 */

namespace Nitrogen\Test;

use Nitrogen\Framework\Responder;

require '../vendor/autoload.php';

class ResponderTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Nitrogen\Interfaces\ResponderInterface */
    private $responder = null;

    public function setUp()
    {
        $this->responder = new Responder();
    }

    public function tearDown()
    {
        unset($this->responder);
    }

    public function testGettingResponse()
    {
        $this->assertInstanceOf(
            '\Psr\Http\Message\ResponseInterface',
            $this->responder->getResponse()
        );
    }

    public function testGettingPayload()
    {
        $this->assertInstanceOf(
            '\Fusion\Payload\Interfaces\PayloadInterface',
            $this->responder->getPayload()
        );
    }

    public function testGettingView()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ViewInterface',
            $this->responder->getView()
        );
    }

    public function testSettingResponse()
    {
        $this->assertInstanceOf('\Nitrogen\Interfaces\ResponderInterface',
            $this->responder->setResponse(
                $this->getMock('\Psr\Http\Message\ResponseInterface')
            )
        );
    }

    public function testSettingPayload()
    {
        $this->assertInstanceOf('\Nitrogen\Interfaces\ResponderInterface',
            $this->responder->setPayload(
                $this->getMock('\Fusion\Payload\Interfaces\PayloadInterface')
            )
        );
    }

    public function testSettingView()
    {
        $this->assertInstanceOf('\Nitrogen\Interfaces\ResponderInterface',
            $this->responder->setView(
                $this->getMock('\Nitrogen\Interfaces\ViewInterface')
            )
        );
    }

    public function testRenderingView()
    {
        $this->assertEquals('', $this->responder->__invoke());
    }

    public function getResponderMock()
    {
        return $this->getMockForAbstractClass('\Nitrogen\Framework\Core\AbstractResponder');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenResponseNotValid()
    {
        $this->responder = $this->getResponderMock();
        $this->responder->getResponse();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenPaylodNotValid()
    {
        $this->responder = $this->getResponderMock();
        $this->responder->getPayload();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenViewNotValid()
    {
        $this->responder = $this->getResponderMock();
        $this->responder->getView();
    }


}