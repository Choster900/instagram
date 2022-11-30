<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SearchController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A
use App\Http\Controllers\PostController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A

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

Route::get('/', function () {
    return Redirect::route('login');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/search/{nick_name}',
        [SearchController::class,'search'])->name('search');

    //RUTA DE PUBLICACIONES
    Route::post('/create-post',
        [PostController::class,'createPost'])->name('create-post');

    Route::get('/list-post',
        [PostController::class,'getPost'])->name('list-post');
    
});
