<?php

namespace App\Core;

abstract class Controller {

    protected function isAuthenticated() {
        return isset($_SESSION['userId']);
    }

    protected function render(string $view, array $data = []) {
        extract($data);

        include "../src/Views/pages/$view.php";
    }

    protected function renderLayout(string $layout, string $view, array $data = []) {
        extract([
            'view' => "../src/Views/pages/$view.php",
            ...$data
        ]);

        include "../src/Views/layouts/$layout.php";
    }

    protected function requestJson() {
        return json_decode(file_get_contents("php://input"), true);
    }

    protected function responseJson(int $code, mixed $data) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }

    protected function redirect(string $url, string $method = 'GET') {
        header("Request Method: $method");
        header("Location: $url");
        exit;
    }

    protected function clearMessages() {
        $_SESSION['error'] = null;
    }
}