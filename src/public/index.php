<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/functions.php';

define('APP_ROOT', dirname(__DIR__));
define('VIEWS_PATH', APP_ROOT . '/views/');
define('UPLOADS_DIR', 'uploads');
define('UPLOADS_PATH', APP_ROOT . '/public/' . UPLOADS_DIR . '/');

use App\App;
use App\Config;
use App\Controllers\DashboardController;
use App\Controllers\DataController;
use App\Controllers\HomeController;
use App\Controllers\TestController;

$app = new App();

// add routes
$app->addRoute('/', HomeController::class, 'index');
// test connection to the database
$app->addRoute('/test-db', TestController::class, 'testDbConnection');
// button to take data from API to insert in DB
$app->addRoute('/fetch-api-data', DataController::class, 'fetchApiData');
// to access the dashboard page
$app->addRoute('/dashboard', DashboardController::class, 'index');



// run app
$app->run();
