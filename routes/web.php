<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrivyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privy/campaigns', [PrivyController::class, 'getCampaigns']);
