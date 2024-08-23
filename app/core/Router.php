<?php

declare(strict_types=1);

namespace app\core;

use app\core\exceptions\UnexpectedURLException;

class Router
{
    private array $routes;

    private function register(string $requestMethod, string $route, callable|array $action)
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }
    public function get(string $route, callable|array $action)
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action)
    {
        return $this->register('post', $route, $action);
    }

    public function resolve(string $route, string $requestMethod)
    {
        $route = explode('?', $route)[0];
        $requestMethod = strtolower($requestMethod);

        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            throw new UnexpectedURLException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }
    }
}
