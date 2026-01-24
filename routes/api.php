<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are stateless and do not use CSRF protection. We expose a
| Midtrans notification endpoint here so Midtrans can post transaction
| updates to our server.
|
*/

Route::post('/midtrans/notification', [PaymentWebhookController::class, 'notification']);
