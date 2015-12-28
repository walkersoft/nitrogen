<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/14/2015
 * Time: 7:23 PM
 */

namespace Nitrogen\Framework;


use Nitrogen\Interfaces\CompositeViewInterface;
use Nitrogen\Interfaces\ViewInterface;

class CompositeView implements CompositeViewInterface
{
    /**
     * Array of views.
     *
     * @var array
     */
    protected $views = [];

    /**
     * Constructor.
     *
     * Accepts an array of initial views. This array may or may not have keys
     * assigned.
     *
     * @param array $views
     */
    public function __construct($views = [])
    {
        foreach ($views as $key => $view)
        {
            $this->insertView($key, $view);
        }
    }

    /**
     * Adds a `ViewInterface` instance to the composite.
     *
     * This method MUST be implemented in such a way as to insert the view into
     * the composite at the next available index. (e.g. numerical array index.)
     *
     * @param \Nitrogen\Interfaces\ViewInterface $view
     * @return self
     */
    public function addView(ViewInterface $view)
    {
        array_push($this->views, $view);
        return $this;
    }

    /**
     * Inserts a `ViewInterface` instance into the composite at an index.
     *
     * This method MUST be implemented in such a way as to insert the view into
     * the composite as a given index and MUST overwrite any view that exists
     * at the given index.
     *
     * The index key MAY be any key that is acceptable as a key in a PHP array.
     *
     * This method MUST throw an exception if the key is invalid.
     *
     * @param mixed $key
     * @param \Nitrogen\Interfaces\ViewInterface $view
     * @return self
     * @throws \InvalidArgumentException When `$key` is invalid.
     */
    public function insertView($key, ViewInterface $view)
    {
        if(!is_int($key) && !is_string($key))
        {
            throw new \InvalidArgumentException(
                sprintf('View key index must be a string or an int. %s given.', gettype($key))
            );
        }

        $this->views[$key] = $view;
        return $this;
    }

    /**
     * Gets a view a the specified index.
     *
     * This method will check the composite for a view at the specified index
     * key and return it.
     *
     * This method MUST throw an exception if the index key is invalid or a
     * view does not exist at the specified index.
     *
     * @param mixed $key
     * @return \Nitrogen\Interfaces\ViewInterface
     * @throws \InvalidArgumentException When `$key` is not valid.
     * @throws \OutOfBoundsException When a view does not exist at the `$key`.
     */
    public function getView($key)
    {
        if(!is_int($key) && !is_string($key))
        {
            throw new \InvalidArgumentException(
                sprintf('View key index must be a string or an int. %s given.', gettype($key))
            );
        }

        if(!array_key_exists($key, $this->views))
        {
            throw new \OutOfBoundsException(
                sprintf('View could not be found at index: %s.', $key)
            );
        }

        return $this->views[$key];
    }

    /**
     * Gets an array of all of the views.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Causes a view to _render_ itself into output for the client.
     *
     * @return mixed The rendered output.
     */
    public function render()
    {
        $output = '';

        foreach ($this->views as $view)
        {
            /** @var \Nitrogen\Interfaces\ViewInterface $view */
            $output .= $view->render();
        }

        return $output;
    }
}