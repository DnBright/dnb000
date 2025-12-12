<?php

protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminAuth::class,

];


