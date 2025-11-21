<?php
use Controllers\UserController;

$controller = new UserController();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'POST' && $uri === '/api/users') {
    $payload = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $controller->create($payload);

    http_response_code($response['status']);
    header('Content-Type: application/json');
    echo json_encode($response['data']);
}
?>