<?php

use App\Blog\BlobModule;
use App\Framework\Kernel;
use App\Framework\Renderer;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require '../vendor/autoload.php';

$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__).'/template');

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
], [
    'renderer' => $renderer
]);
$response = $kernel->run($request);

(new SapiEmitter())->emit($response);