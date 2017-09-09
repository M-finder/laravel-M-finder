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
    
    Route::post('/articles', 'UserHome\ArticleController@articles');
    Route::post('/myarticles', 'UserHome\ArticleController@articles');
    Route::post('/edit-article', 'UserHome\ArticleController@edit_article');
    Route::post('/delete-article', 'UserHome\ArticleController@delete_article');
});
