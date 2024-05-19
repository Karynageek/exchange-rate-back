<?php

use App\Http\Controllers\API\EmailSubscriptionController;
use App\Http\Controllers\API\RateController;
use Illuminate\Support\Facades\Route;

Route::get('/rate', [RateController::class, 'getExchangeRate']);
Route::post('/subscribe', [EmailSubscriptionController::class, 'subscribe']);
Route::post('/send-emails', [EmailSubscriptionController::class, 'sendEmails']);


