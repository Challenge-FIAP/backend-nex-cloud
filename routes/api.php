<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users/', [
    UserController::class, 'index'
]);

Route::get('user/{id}', [
    UserController::class, 'show'
]);

Route::post('user/', [
    UserController::class, 'store'
]);

Route::put('user/{id}/document-name', [
    UserController::class, 'updateDocumentAndName'
]);

Route::put('user/{id}/email-phone', [
    UserController::class, 'updateEmailAndPhone'
]);

Route::put('user/{id}/code', [
    UserController::class, 'verifyCode'
]);

Route::put('user/{id}/password', [
    UserController::class, 'updatePassword'
]);

Route::delete('user/{id}', [
    UserController::class, 'destroy'
]);
