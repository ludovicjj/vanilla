<?php

use App\Blog\BlobModule;
use App\Framework\Kernel;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require '../vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$requestCreator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $requestCreator->fromGlobals();


$kernel = new Kernel([
    BlobModule::class
]);
$response = $kernel->run($request);

(new SapiEmitter())->emit($response);