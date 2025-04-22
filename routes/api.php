<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['csrf_token' => csrf_token()]);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return response()->json([
//         'user' => $request->user(),
//         'role' => $request->user()->role // أو أي طريقة تحصل بها على الـ role
//     ]);
// });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user()->load('roles'); // تحميل العلاقة
    
    return response()->json([
        'user' => $user,
        'roles' => $user->roles->pluck('name'), // أسماء الأدوار
        'primary_role' => $user->roles->first()->name // الدور الأساسي
    ]);
});

