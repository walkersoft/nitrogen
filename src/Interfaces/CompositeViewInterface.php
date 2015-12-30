<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 12/14/2015
 * Time: 6:23 PM
 */

namespace Nitrogen\Interfaces;


interface CompositeViewInterface extends ViewInterface
{
    /**
     * Adds a `ViewInterface` instance to the composite.
     *
     * This method MUST be implemented in such a way as to insert the view into
     * the composite at the next available index. (e.g. numerical array index.)
     *
     * @param \Nitrogen\Interfaces\ViewInterface $view
     *
     * @return self
     */
    public function addView(ViewInterface $view);

    /**
     * Inserts a `ViewInterface` instance into the composite at an index.
     *
     * This method MUST be implemented in such a way as to insert the view into
     * the composite as a given index and MUST overwrite any view that exists
     * at the given index.
     *
     * The index key may be any key that is acceptable as a key in a PHP array.
     *
     * This method MUST throw an exception if the key is invalid.
     *
     * @param mixed $key
     * @param \Nitrogen\Interfaces\ViewInterface $view
     *
     * @return self
     * @throws \InvalidArgumentException When `$key` is invalid.
     */
    public function insertView($key, ViewInterface $view);

    /**
     * Gets a view at the specified index.
     *
     * This method will check the composite for a view at the specified index
     * key and return it.
     *
     * This method MUST throw an exception if the index key is invalid or a
     * view does not exist at the specified index.
     *
     * @param mixed $key
     *
     * @return \Nitrogen\Interfaces\ViewInterface
     * @throws \InvalidArgumentException When `$key` is not valid.
     * @throws \OutOfBoundsException When a view does not exist at the `$key`.
     */
    public function getView($key);

    /**
     * Gets an array of all of the views.
     *
     * @return array
     */
    public function getViews();
}