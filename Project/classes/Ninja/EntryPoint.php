<?php

namespace Ninja;

use ErrorException;

class EntryPoint
{
    private $route;
    private $method;
    private $routes;
    public function __construct(string $route, $method, \Ninja\Routes $routes)
    {
        $this->route = $route;
        $this->method = $method;
        $this->routes = $routes;
        $this->checkUrl();
    }

    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            $this->route = strtolower($this->route);
            http_response_code(301);
            header('location: /' . $this->route);
        }
    }

    // avoids variable name clashes with local environment
    // after 'extraction' from "values['variables']"
    // (scope is limited to function level)
    private function loadTemplate($values)
    {
        $template = $values['template'];
        extract($values['variables']);
        ob_start();
        include __DIR__ . '/../../templates/' . $template . '.html.php'; // values for the specific template are extracted from $values['variables']
        return ob_get_clean();
    }

    public function run()
    {
        $routes = $this->routes->getRoutes();
        $controller = $routes[$this->route][$this->method]['controller'];
        $action = $routes[$this->route][$this->method]['action'];
        // try {
        $values = $controller->$action();
        // } catch ( $e) { // which error is this? How to handle wrong action given?
        //     $values = $controller->home();
        // }
        $title = $values['title'] ?? 'Error';
        $output = $this->loadTemplate($values);
        include __DIR__ . '/../../templates/layout.html.php';
    }
}
