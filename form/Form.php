<?php


namespace app\core\form;
use app\core\Model;

/**
 * Class Form
 * @package app\core\form
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