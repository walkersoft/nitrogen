<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/11/2015
 * Time: 2:06 PM
 */

namespace Nitrogen\Framework\Core;


use Nitrogen\Interfaces\ViewInterface;

class AbstractView implements ViewInterface
{
    /**
     * A template file.
     *
     * Template files will contain text that will be output in the `render()`
     * method.
     *
     * @var string
     */
    protected $template = '';

    /**
     * Template attachments.
     *
     * Associative array with key/value pairs that will be extracted into the
     * template document as variables.
     *
     * @var array
     */
    protected $attachments = [];

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if (file_exists($this->template))
        {
            extract($this->attachments);
            require $this->template;
        }
    }

    /**
     * Sets an attachment in the attachments array.
     *
     * Requires a key and value pair.  The key MUST be a valid PHP variable
     * name and the value can be any value that can be stored in a PHP variable.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return self
     * @throws \InvalidArgumentException When a key is an invalid variable name.
     */
    public function setAttachment($key, $value)
    {
        $validName = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

        if (!is_string($key) || preg_match($validName, $key) !== 1)
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unable to set an attachment with an invalid key. %s given.',
                    (gettype($key) != 'string') ? gettype($key) : $key
                )
            );
        }

        $this->attachments[$key] = $value;
        return $this;
    }

    /**
     * Sets the view's template.
     *
     * @param string $template
     *
     * @return self
     * @throws \InvalidArgumentException When `$template` is not a string.
     */
    public function setTemplate($template)
    {
        if (!is_string($template))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Template must be presented as a string. %s given.', gettype($template)
                )
            );
        }

        $this->template = $template;
        return $this;
    }

}