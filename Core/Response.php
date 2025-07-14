<?php

declare(strict_types=1);

/**
 * File Name: Response.php
 * Description: Handles HTTP response settings.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and additional status codes
 */

namespace Core;

class Response
{
    // Success responses
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;
    public const NO_CONTENT = 204;

    // Redirection responses
    public const MOVED_PERMANENTLY = 301;
    public const FOUND = 302;
    public const SEE_OTHER = 303;
    public const NOT_MODIFIED = 304;
    public const TEMPORARY_REDIRECT = 307;
    public const PERMANENT_REDIRECT = 308;

    // Client error responses
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const NOT_ACCEPTABLE = 406;
    public const CONFLICT = 409;
    public const GONE = 410;
    public const UNPROCESSABLE_ENTITY = 422;
    public const TOO_MANY_REQUESTS = 429;

    // Server error responses
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;
    public const BAD_GATEWAY = 502;
    public const SERVICE_UNAVAILABLE = 503;
    public const GATEWAY_TIMEOUT = 504;

    public static function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public static function json(array $data, int $statusCode = self::OK): never
    {
        self::setStatusCode($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public static function redirect(string $url, int $statusCode = self::FOUND): never
    {
        self::setStatusCode($statusCode);
        header("Location: {$url}");
        exit();
    }

    public static function back(): never
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirect($referrer);
    }
}