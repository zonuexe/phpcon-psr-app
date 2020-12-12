<?php

declare(strict_types=1);

namespace zonuexe\PHPConPsrApp\Http\RequestHandler;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\RequestHandlerInterface;

final class Index implements RequestHandlerInterface
{
    private StreamFactory $stream_factory;
    private ResponseFactory $response_factory;

    public function __construct(ResponseFactory $response_factory, StreamFactory $stream_factory)
    {
        $this->response_factory = $response_factory;
        $this->stream_factory = $stream_factory;
    }

    public function handle(Request $request): Response
    {
        return $this->response_factory->createResponse()
            ->withHeader('Content-Type', 'text/html')
            ->withBody($this->stream_factory->createStream(<<<HTML
                <!DOCTYPE html>
                <title>Hello</title>
                <h1>Hello PHPCon 2020</h1>
                HTML)
            );
    }
}
