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

Route::post('/comments', 'Home\CommentController@comment_search');
Route::post('/comment', 'Home\CommentController@comment');
Route::post('/like', 'Home\ArticleController@like');

Route::prefix('home')->group(function () {
    Route::get('/', 'Home\IndexController@index')->name('home');
    Route::get('/category/{id}', 'Home\CategoryController@category');
    Route::post('/category', 'Home\CategoryController@category');
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
    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
    Route::get('/infoset', 'Admin\AdminController@infoset');
    Route::get('/update-article/{id}', 'Admin\ArticleController@update_article');
    Route::get('/publish-article/{id}', 'Admin\ArticleController@publish_article');
    Route::get('/new-category', 'Admin\MenuController@new_category');
    Route::get('/update-category/{id}', 'Admin\MenuController@update_category');
    Route::get('/category', 'Admin\MenuController@category');
    Route::get('/messages', 'Admin\AdminController@messages');
    Route::get('/edit-feedback/{id}', 'Admin\AdminController@edit_feedback');
    Route::get('/user', 'Admin\UserController@user');
    Route::get('/edit-user/{id}', 'Admin\UserController@edit_user');
    Route::get('/links', 'Admin\AdminController@links');
    Route::get('/edit-links/{id?}', 'Admin\AdminController@edit_links');
    Route::get('/sysconfig', 'Admin\AdminController@sysconfig');
    Route::get('/comments', 'Admin\CommentController@comments');

    Route::post('/articles', 'Admin\ArticleController@articles');
    Route::post('/password_reset', 'Admin\AdminController@password_reset');
    Route::post('/edit-article', 'Admin\ArticleController@edit_article');
    Route::post('/delete-article', 'Admin\ArticleController@delete_article');
    Route::post('/categorys', 'Admin\MenuController@categorys');
    Route::post('/edit-category', 'Admin\MenuController@edit_category');
    Route::post('/delete-category', 'Admin\MenuController@delete_category');
    Route::post('/feedbacks', 'Admin\AdminController@feedbacks');
    Route::post('/save-feedback', 'Admin\AdminController@save_feedback');
    Route::post('/save-article', 'Admin\ArticleController@save_article');
    Route::post('/users', 'Admin\UserController@users');
    Route::post('/save-user', 'Admin\UserController@save_user');
    Route::post('/delete-user', 'Admin\UserController@delete_user');
    Route::post('/get-links', 'Admin\AdminController@get_links');
    Route::post('/save-link', 'Admin\AdminController@save_link');
    Route::post('/delete-link', 'Admin\AdminController@delete_link');
    Route::post('/edit-sysconfig', 'Admin\AdminController@edit_sysconfig');
    Route::post('/get-comments', 'Admin\CommentController@get_comments');
    Route::post('/delete-comments', 'Admin\CommentController@delete_comments');
});


Route::post('/upload-img', 'UploadController@upload_articles_img');
Route::post('/upload-avatar', 'UploadController@upload_articles_avatar');
