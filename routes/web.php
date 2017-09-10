<?php

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

Route::get('/', 'Home\IndexController@index');

Route::post('/comment_search', 'Home\CommentController@comment_search');
Route::post('/comment', 'Home\CommentController@comment');
Route::post('/like', 'Home\ArticleController@like');

Route::prefix('home')->group(function () {
    Route::get('/', 'Home\IndexController@index')->name('home');
    Route::get('/category/{id}', 'Home\CategoryController@category');
    Route::get('/single-page/{id}', 'Home\CategoryController@single_page');
    Route::get('/article-detail/{id}', 'Home\ArticleController@article_detail');
});

Auth::routes();
Route::prefix('userhome')->group(function () {
    Route::get('/', 'AuthController@index')->name('userhome');
    Route::get('/myarticles', 'UserHome\UserController@myarticles');
    Route::get('/new-article', 'UserHome\ArticleController@new_article');
    Route::get('/update-article/{id}', 'UserHome\ArticleController@update_article');
    Route::get('/infoset', 'UserHome\UserController@infoset');
    Route::get('/messages', 'UserHome\UserController@messages');
    Route::get('/contact-back', 'UserHome\UserController@contact_back');

    Route::post('/articles', 'UserHome\ArticleController@articles');
    Route::post('/myarticles', 'UserHome\ArticleController@articles');
    Route::post('/edit-article', 'UserHome\ArticleController@edit_article');
    Route::post('/delete-article', 'UserHome\ArticleController@delete_article');
    Route::post('/message', 'UserHome\UserController@message');
    Route::post('/message/read', 'UserHome\UserController@messageread');
    Route::post('/mymessages', 'UserHome\UserController@mymessages');
    Route::post('/edit_sign', 'UserHome\UserController@edit_sign');
    Route::post('/password_reset', 'UserHome\UserController@password_reset');
    Route::post('/feedback', 'UserHome\UserController@feedback');
    Route::post('/feedbacks', 'UserHome\UserController@feedbacks');
});


Route::prefix('admin')->group(function() {
    Route::get('/login', 'AdminAuthnController@show_login')->name('admin.show_login');
    Route::post('/login', 'AdminAuthnController@login')->name('admin.login');
    Route::post('/logout', 'AdminAuthnController@logout')->name('admin.logout');
});

Route::prefix('admin')->middleware('auth:admin')->group(function() {
    Route::get('/', 'Admin\AdminController@index');
    Route::get('/update-article/{id}', 'Admin\ArticleController@update_article');
    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');

    Route::post('/articles', 'Admin\ArticleController@articles');
    Route::post('/edit-article', 'Admin\ArticleController@edit_article');
    Route::post('/delete-article', 'Admin\ArticleController@delete_article');
});


Route::post('/upload-img', 'UploadController@upload_articles_img');
Route::post('/upload-avatar', 'UploadController@upload_articles_avatar');
