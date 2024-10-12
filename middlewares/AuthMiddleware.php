<?php


namespace vanndy\phpmvc\middlewares;

use vanndy\phpmvc\Application;
use vanndy\phpmvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 * @package vanndy\phpmvc\middlewares
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * AuthMiddleware constructor.
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuess()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
               throw new ForbiddenException();
            }
        }
    }
}