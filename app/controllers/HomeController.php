<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\View;

class HomeController
{
    public function index()
    {
        return View::make('global/index');
    }
}
