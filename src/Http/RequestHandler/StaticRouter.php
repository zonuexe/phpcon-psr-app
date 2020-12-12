<?php

declare(strict_types=1);

namespace zonuexe\PHPConPsrApp\Http\RequestHandler;

use Closure;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\RequestHandlerInterface;

final class StaticRouter implements RequestHandlerInterface
{
    /** @var array<string, array<string, Closure(): RequestHandlerInterface>> */
    private array $routes;
    /** @var Closure(): RequestHandlerInterface */
    private Closure $error_page;

    /**
     * @param array<string, array<string, Closure(): RequestHandlerInterface>> $routes
     * @param  Closure(): RequestHandlerInterface $error_page
     */
    public function __construct(array $routes, Closure $error_page)
    {
        $this->routes = $routes;
        $this->error_page = $error_page;
    }

    public function handle(Request $request): Response
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        return ($this->routes[$path][$method] ?? $this->error_page)()->handle($request);
    }
}
