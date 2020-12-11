<?php

declare(strict_types=1);

use Narrowspark\HttpEmitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use zonuexe\PHPConPsrApp\Http\RequestHandler\Hello;

require __DIR__ . '/../vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$response = (new Hello($psr17Factory, $psr17Factory))->handle($serverRequest);

$emitter = new SapiEmitter();
$emitter->emit($response);
