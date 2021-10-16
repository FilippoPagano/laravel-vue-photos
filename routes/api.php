<?php

use App\Models\Like;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/like/{user}/{photo}', function ($user, $photo) {
    try {
        $like = Like::create([
            'photo' => $photo,
            'user' => $user,
        ]);
    } catch (Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode != 1062) {
            throw $e;
        }
    }
    return 'ok';
});

Route::post('/unlike/{user}/{photo}', function ($user, $photo) {
    $like = Like::where('user', '=', $user)->where('photo', '=', $photo)->first();
    if ($like) {
        $like->delete();
    }

    return 'ok';
});

Route::get('/likes', function () {
    return Like::orderBy('created_at', 'desc')->get();
});
