<?php

declare(strict_types=1);

namespace app\core;

class DB
{
    private \PDO $pdo;

    public function __construct(array $config)
    {
        $defaultParams = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];
        try {
            $this->pdo = new \PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                username: $config['username'],
                password: $config['password'],
                options: $config['params'] ?? $defaultParams
            );
        } catch (\Throwable $th) {
            echo $th->getMessage() . ' ' . $th->getCode() . '<br/>';
        }
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->pdo,$name], $arguments);
    }
}
