<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryApiController;

use App\Models\User;


Route::apiResource("/categories", CategoryApiController::class);

Route::post("/login", function() {
    $email = request()->email;
    $password = request()->password;

    $user = User::where("email", $email)->first();

    if($user) {
        if(password_verify($password, $user->password)) {
            return [ 'token' => $user->createToken("web")->plainTextToken];
        }

        return response(['msg' => "Incorrect password"], 401);
    }

    return response(['msg' => "Incorrect password"], 401);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
