<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SearchController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A
use App\Http\Controllers\PostController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A
use App\Http\Controllers\ProfileController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A
use App\Http\Controllers\ChatController;//TODO: ESTO TIENE QUE IR EN MAYUSCULA LA LETRA A

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

    Route::get('/search_user_from_chat/{nick_name}',//ruta que usaremos en axios
        [SearchController::class,'userIFollow'])->name('search');//metodo que se buscara en la clase 

    //RUTA DE PUBLICACIONES
    Route::post('/create-post',
        [PostController::class,'createPost'])->name('create-post');

    Route::get('/list-post',
        [PostController::class,'getPost'])->name('list-post');
    
    Route::post('/like-post',
        [PostController::class,'giveLikeOrDislike'])->name('like-post');

    Route::post('/comment',
        [PostController::class,'comment'])->name('comment');

    //rutas hacia profile
    Route::get('/profile/{nick_name}',
        [ProfileController::class,'index'])->name('profile');

    Route::get('/chats',
        [ChatController::class,'index'])->name('profile');
});
