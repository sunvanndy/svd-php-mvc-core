<?php
/**
 * Created DateTime: 6/29/2024, 3:43 PM
 */

/**
 * Class Controller
 *
 * @package vanndy\phpmvc
 */

namespace vanndy\phpmvc;


use vanndy\phpmvc\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var vanndy\phpmvc\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return vanndy\phpmvc\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}