<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/27/2015
 * Time: 6:47 PM
 */

namespace Nitrogen\Test;


use Nitrogen\Framework\CompositeView;
use Nitrogen\Framework\View;

class CompositeViewTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Nitrogen\Interfaces\CompositeViewInterface $view */
    private $view = null;

    public function setUp()
    {
        $this->view = new CompositeView();
    }

    public function tearDown()
    {
        unset($this->view);
        if(file_exists('foo.txt'))
        {
            unlink('foo.txt');
        }
    }

    public function testAddingView()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\CompositeViewInterface',
            $this->view->addView(new View(''))
        );
    }

    public function testInsertingView()
    {
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\CompositeViewInterface',
            $this->view->insertView('foo', new View(''))
        );
    }

    public function testGettingView()
    {
        $view = new View('');
        $this->view->addView($view);
        $this->assertInstanceOf(
            '\Nitrogen\Interfaces\ViewInterface',
            $this->view->getView(0)
        );
        $this->assertSame($view, $this->view->getView(0));
    }

    public function testOverwritingInsertedView()
    {
        $foo = new View('');
        $bar = new View('');
        $this->assertNotSame($foo, $bar);

        $this->view->insertView('baz', $foo);
        $this->assertSame($this->view->getView('baz'), $foo);

        $this->view->insertView('baz', $bar);
        $this->assertSame($this->view->getView('baz'), $bar);
    }

    public function testGettingAllViews()
    {
        $this->view->addView(new View(''));
        $this->view->addView(new View(''));
        $this->view->addView(new View(''));
        $this->view->addView(new View(''));
        $this->view->addView(new View(''));
        $this->assertInternalType('array', $this->view->getViews());
        $this->assertEquals(5, count($this->view->getViews()));
    }

    public function testRenderingComposite()
    {
        $this->makeFooFile();
        $this->view->addView(new View('foo.txt'));
        $this->view->addView(new View('foo.txt'));
        $this->view->addView(new View('foo.txt'));

        ob_start();
        $this->view->render();
        $this->assertEquals('foobarfoobarfoobar', ob_get_clean());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badStringOrIntData
     * @param $key
     */
    public function testExceptionThrownWhenInsertKeyIsBad($key)
    {
        $this->view->insertView($key, new View(''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badStringOrIntData
     * @param $key
     */
    public function testExceptionThrownWhenRetrievalKeyIsBad($key)
    {
        $this->view->getView($key);
    }

    /**
     * @expectedException \OutOfBoundsException
     * @dataProvider validButMissingKey
     * @param $key
     */
    public function testExceptionThrownWhenViewKeyDoesNotExist($key)
    {
        $views = [
            'bar' => new View(''),
            new View('')
        ];

        $this->view = new CompositeView($views);
        $this->view->getView($key);
    }

    public function makeFooFile()
    {
        $f = fopen('foo.txt', 'w');
        fwrite($f, 'foobar');
        fclose($f);
    }

    public function badStringOrIntData()
    {
        return [
            [null],
            [true],
            [102.1092],
            [fopen('php://memory', 'r')],
            [new \stdClass()],
            [[]]
        ];
    }

    public function validButMissingKey()
    {
        return [
            [2],
            ['foo'],
            ['']
        ];
    }
}