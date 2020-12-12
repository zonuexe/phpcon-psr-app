<?php

declare(strict_types=1);

namespace zonuexe\PHPConPsrApp\Http\RequestHandler;

use function ob_start;
use function ob_get_clean;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\RequestHandlerInterface;

final class PHPInfo implements RequestHandlerInterface
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
        ob_start();
        phpinfo();
        $body = ob_get_clean();

        return $this->response_factory->createResponse()
            ->withHeader('Content-Type', 'text/html')
            ->withBody($this->stream_factory->createStream($body));
    }
}
