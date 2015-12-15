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
}