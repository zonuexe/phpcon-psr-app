<?php

declare(strict_types=1);

use Narrowspark\HttpEmitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use zonuexe\PHPConPsrApp\Http\RequestHandler\ErrorPage;
use zonuexe\PHPConPsrApp\Http\RequestHandler\Hello;
use zonuexe\PHPConPsrApp\Http\RequestHandler\Index;
use zonuexe\PHPConPsrApp\Http\RequestHandler\PHPInfo;
use zonuexe\PHPConPsrApp\Http\RequestHandler\StaticRouter;

require __DIR__ . '/../vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$router = new StaticRouter([
    '/' => ['GET' => fn() => new Index($psr17Factory, $psr17Factory)],
    '/hello' => ['GET' => fn() => new Hello($psr17Factory, $psr17Factory)],
    '/phpinfo' => ['GET' => fn() => new PHPInfo($psr17Factory, $psr17Factory)],
], fn() => new ErrorPage($psr17Factory, $psr17Factory));

$response = $router->handle($serverRequest);

$emitter = new SapiEmitter();
$emitter->emit($response);
