<?php
namespace App\Core;

use App\Database\DB;

/**
 * A very basic router.
 * Simon Champion, April 2021.
 */
class Router
{
    const CONFIG_FILE = '/../config/routes.json';

    private $routes = [];
    private $db;

    public function __construct(DB $db)
    {
        $routeConfig = file_get_contents(dirname(__DIR__) . self::CONFIG_FILE);
        $this->routes = json_decode($routeConfig, true);
        $this->db = $db;
    }

    public function routeTo($fullLocation)
    {
        $location = preg_replace('~/?(\?.*)?$~', '', $fullLocation);
        if (file_exists($location)) {
            return false;
        }
        $route = $this->routes[$location]['controller'] ?? null;
        $html = $this->routes[$location]['template'] ?? null;

        if ($route) {
            $class = "\\App\\Controller\\{$route}";
            if (class_exists($class)) {
                $controller = new $class(new Request($fullLocation), $this->db);
                $method = $this->routes[$location]['method'] ?? 'index';
                $isApi = $method === '%REQUEST_METHOD';
                if ($isApi) {
                    $method = strtolower($_SERVER['REQUEST_METHOD']);
                    if (!method_exists($controller, $method)) {
                        throw new \Exception("Request method {$method} not allowed");
                    }
                }
                if (!method_exists($controller, $method)) {
                    $method = 'index';
                }
                $output = $controller->$method();
                if ($isApi) {
                    header('Content-Type: application/json');
                    return json_encode($output);
                }
                return $output;
            }
            throw new \Exception("Route $route not found.");
        }

        if ($html) {
            $template = dirname(__DIR__) . "/../App/Templates/{$html}";
            if (file_exists($template)) {
                return file_get_contents($template);
            }
            throw new \Exception("Template $template not found.");
        }

        throw new \Exception("404 Page not found"); //@todo replace with actual 404.
    }
}

