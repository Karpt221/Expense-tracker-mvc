<?php

declare(strict_types = 1);

namespace app\core;

class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'username'     => $env['DB_USER'],
                'password'     => $env['DB_PASS'],
                'dbname' => $env['DB_NAME']
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}