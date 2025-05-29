<?php
declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php';

$pdo = require __DIR__.'/../config/database.php';
session_start();

$controllerName = $_GET['c'] ?? 'auth';
$action         = $_GET['a'] ?? 'login';

$cls = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';
if (!class_exists($cls)) {
    http_response_code(404);
    exit('Controller non trovato');
}
$controller = new $cls($pdo);
if (!method_exists($controller, $action)) {
    http_response_code(404);
    exit('Azione non trovata');
}
$controller->$action();
