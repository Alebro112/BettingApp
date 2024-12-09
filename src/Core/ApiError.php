<?php

namespace App\Core;

class ApiError
{
    private int $statusCode;
    private string $message;
    private array $details;

    public function __construct(int $statusCode, string $message, array $details = [])
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->details = $details;
    }

    public function toJson(): string
    {
        http_response_code($this->statusCode);
        return json_encode([
            'message' => $this->message,
            'details' => $this->details
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function send(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo $this->toJson();
        exit;
    }

    public static function forbidden(array $details = []): void
    {
        (new self(403, 'Forbidden', $details))->send();
    }

    public static function unauthorized(array $details = []): void
    {
        (new self(401, 'Unauthorized', $details))->send();
    }

    public static function badRequest(string $message = 'Bad Request', array $details = []): void
    {
        (new self(400, $message, $details))->send();
    }

}
