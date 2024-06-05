<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


Route::get("/user", [UserController::class, "index"]);

Route::post("/user/create", function (StoreUserRequest $request, Response $response) {
    return (new UserController)->store($request, $response);
});

Route::put("/user/update/{id}", function (UpdateUserRequest $request, $id) {
    return (new UserController)->update($request, $id);
});
Route::get('/transfer', [TransferController::class, "index"]);

Route::post("/transfer", function (StoreTransferRequest $request, Response $response) {
    return (new TransferController)->store($request, $response);
});


Route::post('/createAccount', function (StoreAccountRequest $request, Response $response) {
    return (new AccountController)->store($request, $response);
});

Route::get('/account/{user_id}', function ($user_id) {
    return (new AccountController)->show($user_id);
});
