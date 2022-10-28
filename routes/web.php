<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// login register
Route::middleware('admin_auth')->group(function(){
    Route::redirect('/', 'loginPage');
    Route::get('/loginPage', [AuthController::class, 'loginPage'])->name('auth#login');
    Route::get('/registerPage', [AuthController::class, 'registerPage'])->name('auth#register');
});

Route::middleware(['auth'])->group(function () {
    // 'auth:sanctum',config('jetstream.auth_session'),'verified'
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // Route::group(['middleware' => 'auth#login'],function(){

    // })


    // admin
    Route::middleware('admin_auth')->group(function(){
        // category
        Route::group(['prefix' => 'category'], function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('create#category');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('delete#category');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit#category');
            Route::post('update', [CategoryController::class, 'update'])->name('update#category');
        });
        // admin account
        Route::prefix('admin')->group(function(){
            // password
            Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('password/change',[AdminController::class,'changePassword'])->name('admin#changePassword');

            // account profile
            Route::get('account/detail',[AdminController::class,'detail'])->name('admin#detail');
            Route::get('account/edit',[AdminController::class,'edit'])->name('admin#edit');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');

            // admin list
            Route::get('list',[AdminController::class,'listPage'])->name('admin#listPage');
            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
            // Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');
            Route::get('role/change',[AdminController::class,'changeRole']);

            // user list
            Route::get('account/user',[AccountController::class, 'userListPage'])->name('admin#userList');
            Route::get('account/user/role',[AccountController::class,'changeUserRole']);
            Route::get('account/user/delete',[AccountController::class, 'userAccDel']);

            // contact list
            Route::prefix('contact')->group(function(){
                Route::get('list',[ContactController::class,'contactList'])->name('admin#contactList');
                Route::get('detail/{id}',[ContactController::class,'contactDetail'])->name('admin#contactDetail');
                Route::get('delete',[ContactController::class,'contactDelete']);
            });
        });

        // product
        Route::prefix('product')->group(function(){
            Route::get('list',[ProductController::class,'list'])->name('product#list');
            Route::get('createPage',[ProductController::class,'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class,'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
            Route::get('viewPage/{id}',[ProductController::class,'viewPage'])->name('product#viewPage');
            Route::get('update/{id}',[ProductController::class,'updatePage'])->name('product#updatePage');
            Route::post('update',[ProductController::class,'update'])->name('product#update');
        });

        // order
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'listPage'])->name('order#listPage');
            Route::get('ajax/status',[OrderController::class,'ajaxStatus']);
            Route::get('ajax/status/change',[OrderController::class,'statusChange']);
            Route::get('detail/{code}',[OrderController::class,'detailPage'])->name('order#detailPage');
        });
    });


    // user
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'],function(){
        Route::get('home',[UserController::class,'homePage'])->name('user#home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');
        Route::get('history',[UserController::class,'history'])->name('user#history');
        Route::get('contact',[ContactController::class,'contactPage'])->name('user#contactPage');

        // pizza
        Route::prefix('pizza')->group(function(){
            Route::get('pizzaDetail/{id}',[UserController::class,'pizzaDetail'])->name('pizza#detail');
        });

        // cart
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('cart#cartList');
        });

        // password
        Route::get('passwordChangePage',[UserController::class,'passwordChangePage'])->name('user#passwordChangePage');
        Route::post('changePassword',[UserController::class,'changePassword'])->name('user#changePassword');

        // account
        Route::get('changeAccount',[UserController::class,'changeAccountPage'])->name('user#changeAccountPage');
        Route::post('changeAccount/{id}',[UserController::class,'changeAccount'])->name('user#changeAccount');

        // contact
        Route::post('contact',[ContactController::class,'contact'])->name('user#contact');

        // ajax
        Route::prefix('ajax')->group(function(){
            Route::get('pizzaList',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
            Route::get('cart',[AjaxController::class,'addToCart']);
            Route::get('order',[AjaxController::class,'order']);
            Route::get('cart/clear',[AjaxController::class,'clearCart']);
            Route::get('cart/product/clear',[AjaxController::class,'productClear']);
            Route::get('product/view',[AjaxController::class,'productView']);
        });
    });

});
