<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 12/14/2015
 * Time: 3:45 PM
 */

namespace Nitrogen\Framework;

use Nitrogen\Framework\Core\AbstractView;

class View extends AbstractView
{
    /**
     * Constructor.
     *
     * Basic view implementation.  Accepts a string that is a template files and
     * an array of attachments that will be extracted into the view.
     *
     * @param string $template
     * @param array $attachments
     */
    public function __construct($template, $attachments = [])
    {
        $this->setTemplate($template);

        foreach($attachments as $key => $attachment)
        {
            $this->setAttachment($key, $attachment);
        }
    }
}