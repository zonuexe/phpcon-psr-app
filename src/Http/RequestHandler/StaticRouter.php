<?php

declare(strict_types=1);

namespace zonuexe\PHPConPsrApp\Http\RequestHandler;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\RequestHandlerInterface;

final class StaticRouter implements RequestHandlerInterface
{
    /** @var array<string, array<string, Closure(): RequestHandlerInterface>> */
    private array $routes;

    /**
     * @param array<string, array<string, Closure(): RequestHandlerInterface>> $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function handle(Request $request): Response
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        return $this->routes[$path][$method]()->handle($request);
    }
}
