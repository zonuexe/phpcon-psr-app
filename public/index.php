<?php

declare(strict_types=1);

use Narrowspark\HttpEmitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require __DIR__ . '/../vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$response = $psr17Factory->createResponse()
    ->withHeader('Content-Type', 'text/plain')
    ->withBody($psr17Factory->createStream('Hello!'));

$emitter = new SapiEmitter();
$emitter->emit($response);
