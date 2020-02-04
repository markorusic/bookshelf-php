<?php

namespace App\Core\Http;

class Request
{
    /**
     * Fetch the request URI.
     *
     * @return string
     */
    public static function uri() {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }

    /**
     * Fetch the request method.
     *
     * @return string
     */
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Fetch the request params.
     *
     * @return array
     */
    public static function queryParams() {
        return (array) $_REQUEST;
    }

    /**
     * Fetch the request body.
     *
     * @return array
     */
    public static function body() {
        return (array) json_decode(file_get_contents('php://input'));
    }

}
