<?php


namespace vanndy\phpmvc\form;
use vanndy\phpmvc\Model;

/**
 * Class Form
 * @package vanndy\phpmvc\form
 */

class Form
{
    public static function begin($action, $method)
    {
        // sprintf will accept string and additional arguments
        echo sprintf('<form action="%s" method="%s">', $action, $method);

        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}