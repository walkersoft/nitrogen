<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/27/2015
 * Time: 4:22 PM
 */

namespace Nitrogen\Test;

use Nitrogen\Framework\View;

class AbstractViewTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Nitrogen\Framework\Core\AbstractView $view */
    private $view = null;

    public function setUp()
    {
        $this->view = new View('foo.txt');
    }

    public function tearDown()
    {
        unset($this->view);
        if (file_exists('bar.txt'))
        {
            unlink('bar.txt');
        }
        if (file_exists('foobar.txt'))
        {
            unlink('foobar.txt');
        }
    }

    public function testSettingTemplate()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ViewInterface',
            $this->view->setTemplate('foo.txt')
        );
    }

    public function testSettingAttachment()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ViewInterface',
            $this->view->setAttachment('foo', ['bar'])
        );
    }

    public function testSettingUpWithMultipleAttachments()
    {
        $attachments = [
            'bar' => 'foo',
            'foo' => 'bar'
        ];
        $this->makeFooBarFile();
        $this->view = new View('foobar.txt', $attachments);

        ob_start();
        $this->view->render();
        $this->assertEquals('barfoo', ob_get_clean());
    }

    public function testRenderingViewWithAttachments()
    {
        ob_start();
        $this->makeBarFile();
        $this->view->setTemplate('bar.txt');
        $this->view->setAttachment('foo', ['bar']);
        $this->view->render();
        $this->assertEquals('bar', ob_get_clean());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badAttachmentKeyData
     *
     * @param $key
     */
    public function testExceptionThrowWithBadAttachmentKey($key)
    {
        $this->view->setAttachment($key, 'foobar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badStringData
     *
     * @param $template
     */
    public function testExceptionThrowWithBadTemplate($template)
    {
        $this->view->setTemplate($template);
    }

    public function makeBarFile()
    {
        $f = fopen('bar.txt', 'w');
        fwrite($f, '<?php echo $foo[0]; ?>');
        fclose($f);
    }

    public function makeFooBarFile()
    {
        $f = fopen('foobar.txt', 'w');
        fwrite($f, '<?php echo $foo . $bar; ?>');
        fclose($f);
    }

    public function badAttachmentKeyData()
    {
        return [
            [null],
            [true],
            [1029],
            [20109.10018],
            [fopen('php://memory', 'r')],
            [new \stdClass()],
            [[]],
            [''],
            ['123']
        ];
    }

    public function badStringData()
    {
        return [
            [null],
            [true],
            [1029],
            [20109.10018],
            [fopen('php://memory', 'r')],
            [new \stdClass()],
            [[]]
        ];
    }
}