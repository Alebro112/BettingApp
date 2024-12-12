<?php

namespace App\Core;

class ApiError
{
    private $code;
    private $message;
    private $redirectUrl;

    public function __construct($code, $message, $redirectUrl = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->redirectUrl = $redirectUrl;
    }

    private function sendResponse(): never
    {
        #http_response_code($this->code);
        $_SESSION['error'] = $this->message;

        if ($this->redirectUrl) {
            #header('Request-Method: GET');
            #header("HTTP/1.0 {$this->code} {$this->message}");
            #header("Cahce-Control: no-cache, must-revalidate");
            header('Location: ' . $this->redirectUrl, true, 302);
        }
        exit();
    }

    public static function handle($code, $message, $redirectUrl = null): void
    {
        $error = new self($code, $message, $redirectUrl);
        $error->sendResponse();
    }

    public static function badRequest($redirectUrl, $message = 'Bad Request'): void
    {
        (new self(400, $message, $redirectUrl))->sendResponse();
    }

    public static function unauthorized($redirectUrl, $message = 'Unauthorized'): void
    {
        (new self(401, $message, $redirectUrl))->sendResponse();
    }

    public static function forbidden($redirectUrl, $message = 'Forbidden'): void
    {
        (new self(403, $message, $redirectUrl))->sendResponse();
    }
}
