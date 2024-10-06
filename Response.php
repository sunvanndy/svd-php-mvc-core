<?php
/**
 * Created DateTime: 6/29/2024, 2:40 PM
 * @namespace app\core
 */

namespace app\core;


class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: '. $url);
    }
}