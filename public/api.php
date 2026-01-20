<?php

require __DIR__ . '/../vendor/autoload.php';

use Todo\Api\TodoController;

header('Content-Type: application/json');

$controller = new TodoController();
$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true) ?? [];

if ($method === 'GET') {
    echo json_encode($controller->list());
    exit;
}

if ($method === 'POST') {
    echo json_encode($controller->create($input));
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
