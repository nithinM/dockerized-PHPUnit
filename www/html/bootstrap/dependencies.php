<?php
/**
 * Created by PhpStorm.
 * User: nithin
 * Date: 6/9/17
 * Time: 6:08 AM
 */

use duncan3dc\Laravel\BladeInstance;
use Kunststube\CSRFP\SignatureGenerator;
use Acme\Http;

$injector = new Auryn\Injector;

$signer = new SignatureGenerator(getenv('CSRF_SECRET'));
$injector->share($signer);

$blade = new BladeInstance(getenv('VIEWS_DIRECTORY'), getenv('CACHE_DIRECTORY'));
$injector->share($blade);

$injector->make(Http\Request::class);
$injector->make(Http\Response::class);
$injector->make(Http\Session::class);

$injector->share('Acme/Http/Request');
$injector->share('Acme/Http/Response');
$injector->share('Acme/Http/Session');

return $injector;