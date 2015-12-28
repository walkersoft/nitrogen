<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/27/2015
 * Time: 4:05 PM
 */

namespace Nitrogen\Test;

use Nitrogen\Framework\View;

class ViewTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Nitrogen\Interfaces\ViewInterface $view */
    private $view = null;

    public function setUp()
    {
        $this->view = new View('foo.txt');
    }

    public function tearDown()
    {
        unset($this->view);
        if(file_exists('foo.txt'))
        {
            unlink('foo.txt');
        }
    }

    public function testRenderingTemplate()
    {
        ob_start();
        $this->makeFooFile();
        $this->view->render();
        $this->assertEquals('foobar', ob_get_clean());
    }

    public function makeFooFile()
    {
        $f = fopen('foo.txt', 'w');
        fwrite($f, 'foobar');
        fclose($f);
    }
}