<?php

declare(strict_types=1);

require __DIR__ . '/../' . 'vendor/autoload.php';

use app\controllers\HomeController;
use app\controllers\TransactionsController;
use app\core\App;
use app\core\Config;
use app\core\Router;

define('VIEWS_DIR', __DIR__ . '/../' . 'app/views');
define('UPLOADS_DIR', __DIR__ . '/../' . 'uploads');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

$router = new Router();

$router
        ->get('/', [HomeController::class, 'index'])
        ->get('/transactions', [TransactionsController::class, 'index'])
        ->get('/transactions/create', [TransactionsController::class, 'createForm'])
        ->get('/transactions/update', [TransactionsController::class, 'updateForm'])
        ->get('/transactions/delete', [TransactionsController::class, 'deleteForm'])
        ->post('/transactions/update', [TransactionsController::class, 'update'])
        ->post('/transactions/delete', [TransactionsController::class, 'delete'])
        ->post('/transactions/import', [TransactionsController::class, 'import'])
        ->post('/transactions/export', [TransactionsController::class, 'export'])
        ->post('/transactions/create',[TransactionsController::class, 'create'])
        ->post('/transactions/delete',[TransactionsController::class, 'delete']);

(new App(
        $router,
        [
                'uri' => $_SERVER['REQUEST_URI'],
                'method' => $_SERVER['REQUEST_METHOD']
        ],
        new Config($_ENV)
))->run();

// (new App(
//         $router,
//         [
//                 'uri' => '/transactions/delete',//$_SERVER['REQUEST_URI'],
//                 'method' => 'GET',//$_SERVER['REQUEST_METHOD']
//         ],
//         new Config($_ENV)
// ))->run();

// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';