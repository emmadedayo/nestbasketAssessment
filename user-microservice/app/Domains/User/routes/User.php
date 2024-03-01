<?php

use App\Domains\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('/add', [UserController::class, 'createUser']);
});
