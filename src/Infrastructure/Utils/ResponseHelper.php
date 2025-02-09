<?php

namespace ChatApp\Infrastructure\Utils;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class ResponseHelper
{
    public static function jsonResponse(array $data, int $status = 200): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        return $response->withHeader('Content-Type', 'Application/json')->withStatus($status);
    }
}
