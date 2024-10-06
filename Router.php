<?php
/**
 * Created DateTime: 6/21/2024, 10:53 PM
 * @package app\core
 */

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router constructor.
     * @param \app\core\Request $request
     * @param \app\core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // $this->response->setStatusCode(404);
            // echo $this->renderView("_404");
            throw new NotFoundException();
//            return;
        }

        if (is_string($callback)) {
            echo Application::$app->view->renderView($callback);
            return;
        }

        // OPTIONAL
        if(is_array($callback)) {
            // Shortcut replace all found: Control+option(ALT)+v
            /** @var \app\core\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        echo call_user_func($callback, $this->request, $this->response);
        // RETURN is optional
        return;
    }
}