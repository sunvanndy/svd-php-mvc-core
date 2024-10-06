<?php


namespace app\core;


class View
{

    // TODO: Dynamic title: 4:57:00 -> Paused at 5:07:20 (Finished)
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params); // Render View first, to get value of page title: When View is render, title is already set
        $layoutContent = $this->layoutContent(); // Render Layout Content later to show proper page title
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout; // by default = main
        // if Controller Existed, then we assign the controller to the layout
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            // if this value is name, this will be name variable
            $$key = $value;
        }
        ob_start();

        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}