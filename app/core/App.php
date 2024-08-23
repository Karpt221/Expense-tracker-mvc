<?php

declare(strict_types=1);

namespace app\core;

use app\core\Router;
use app\core\Config;
use app\core\exceptions\UnexpectedURLException;

class App
{
    private static DB $db;
    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config
    ) {
        static::$db = new DB($config->db);
    }

    public static function db()
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve(
                $this->request['uri'],
                $this->request['method']
            );
        } catch (UnexpectedURLException) {
            http_response_code(404);
            echo View::make('global/404');
        }
    }
}
