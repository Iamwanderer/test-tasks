<?php

namespace config;

use \Controllers\SiteController;

class Router
{
    public function makeRoutes()
    {
        $routes = [
            '/' => 'getIndex',
            '/set' => 'setData',
            '/get' => 'getData',
            '/success' => 'successNotice',
            '/absence' => 'absenceNotice',
        ];

        function getRequestPath()
        {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            return '/' . ltrim(str_replace('index.php', '', $path), '/');
        }

        function getMethod(array $routes, $path)
        {
            foreach ($routes as $route => $method) {
                if ($path === $route) {
                    return $method;
                }
            }

            return 'notFound';
        }

        $path = getRequestPath();
        $method = getMethod($routes, $path);

        (new SiteController)->$method();
    }
}
