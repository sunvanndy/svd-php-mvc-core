<?php


namespace app\core\exception;

/**
 * Class ForbiddenException extend the core class Exception form PHP
 * @package app\core\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You have no permission to access this page!';
    protected $code = 403;
}