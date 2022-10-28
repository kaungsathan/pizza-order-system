<?php

use App\Http\Controllers\API\RouteController;
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

Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);

// create category
Route::post('create/category',[RouteController::class,'createCategory']);
// delete category
Route::get('delete/category/{id}',[RouteController::class,'deleteCategory']);
// detail category
Route::get('category/list/{id}', [RouteController::class, 'categoryDetail']);
// update category
Route::post('update/category',[RouteController::class,'updateCategory']);
