<?php

namespace App\Core;

class ApiError
{
    private $code;
    private $message;
    private $redirectUrl;

    public function __construct($code, $message, $redirectUrl = null) {
        $this->code = $code;
        $this->message = $message;
        $this->redirectUrl = $redirectUrl;
    }

    private function sendResponse(): never {
        http_response_code($this->code);
        $_SESSION['error'] = $this->message;

        if ($this->redirectUrl) {
            header('Request-Method: GET');
            header('Location: ' . $this->redirectUrl);
        }
        exit;
    }

    public static function handle($code, $message, $redirectUrl = null): void {
        $error = new self($code, $message, $redirectUrl);
        $error->sendResponse();
    }

    public static function badRequest($message = 'Bad Request', $redirectUrl = null): void {
        (new self(400, $message, $redirectUrl))->sendResponse();
    }

}
