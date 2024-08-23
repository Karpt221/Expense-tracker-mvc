<?php

namespace app\core;

use app\core\exceptions\IncorrectViewPathException;

class View
{
    private function __construct(
        public string $view,
        public array $param = []
    ) {}

    public static function make(string $view, array $param = [])
    {
        return (new View($view, $param))->render();
    }

    public function render()
    {
        $view = VIEWS_DIR . '/' . $this->view . '.php';

        if (! file_exists($view)) {
            throw new IncorrectViewPathException();
        }

        extract($this->param);

        ob_start();

        include $view;

        return ob_get_clean();
    }
}
