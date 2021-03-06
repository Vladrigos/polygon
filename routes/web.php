<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//namespace где искать контроллеры, у нас в пабке Blog
//prefix, /blog/posts, добавляет префикс /blog/ в начало
//resourse REST, благодаря одной записи 7 маршрутов
//екзепт можно написать и не создаст маршруты которые указал
Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function(){
    Route::resource('posts', 'PostController')->names('blog.posts');
});

Route::resource('rest', 'RestTestController')->names('restTest');

//Админка блога
$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix'    => 'admin/blog',
];
Route::group($groupData, function(){
    //BlogCategory
    $methods = ['index', 'edit', 'update', 'create', 'store',];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPosts
    Route::resource('posts', 'PostController')
        ->except(['show'])
        ->names('blog.admin.posts');
});
