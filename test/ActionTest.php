<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/14/2015
 * Time: 7:54 PM
 */

namespace Nitrogen\Test;


use Nitrogen\Framework\Action;

require '../vendor/autoload.php';

class ActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nitrogen\Interfaces\ActionInterface
     */
    private $action = null;

    public function setUp()
    {
        $this->action = new Action();
    }

    public function tearDown()
    {
        unset($this->action);
    }

    public function testGettingResponder()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ResponderInterface',
            $this->action->getResponder()
        );
    }

    public function testSettingResponder()
    {
        /** @var \Nitrogen\Interfaces\ResponderInterface $mock */
        $mock = $this->getMock('\Nitrogen\Interfaces\ResponderInterface');

        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ActionInterface',
            $this->action->setResponder($mock)
        );
    }

    public function testGettingDomainPayload()
    {
        $this->assertInstanceOf(
            '\Fusion\Payload\Interfaces\DomainPayloadInterface',
            $this->action->getDomainPayload()
        );
    }

    public function testSettingDomainPayload()
    {
        /** @var \Nitrogen\Interfaces\ResponderInterface $mock */
        $mock = $this->getMock('\Fusion\Payload\Interfaces\DomainPayloadInterface');

        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ActionInterface',
            $this->action->setDomainPayload($mock)
        );
    }

    public function testGettingRequest()
    {
        $this->assertInstanceOf(
            '\Psr\Http\Message\ServerRequestInterface',
            $this->action->getRequest()
        );
    }

    public function testSettingRequest()
    {
        /** @var \Psr\Http\Message\ServerRequestInterface $mock */
        $mock = $this->getMock('\Psr\Http\Message\ServerRequestInterface');

        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ActionInterface',
            $this->action->setRequest($mock)
        );
    }

    public function testInvokingActionReturnsNull()
    {
        $this->assertNull($this->action->__invoke());
    }

    public function testInvokingActionReturnsResponder()
    {
        //$mock = $this->getMock('\Nitrogen\Framework\Action', ['__invoke']);
        $mock = $this->getMockBuilder('\Nitrogen\Framework\Action')
                     ->setMethods(['__invoke'])
                     ->getMock();
        $mock->expects($this->once())
             ->method('__invoke')
             ->will($this->returnValue($this->getMock('\Nitrogen\Interfaces\ResponderInterface')));

        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ResponderInterface',
            $mock->__invoke()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownGettingResponder()
    {
        $mock = $this->getMockForAbstractClass('\Nitrogen\Framework\Core\AbstractAction');
        $this->action = $mock;
        $this->action->getResponder();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownGettingDomainPayload()
    {
        $mock = $this->getMockForAbstractClass('\Nitrogen\Framework\Core\AbstractAction');
        $this->action = $mock;
        $this->action->getDomainPayload();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownGettingRequest()
    {
        $mock = $this->getMockForAbstractClass('\Nitrogen\Framework\Core\AbstractAction');
        $this->action = $mock;
        $this->action->getRequest();
    }
}