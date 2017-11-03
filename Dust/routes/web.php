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


// 메인 페이지
Route::get('/', 'DustController@index')->name('DustMain');
// 슬라이드 페이지
Route::get('/slide','SlideController@index')->name('SlideMain');



// api-----------------

// 선택된 날짜의 슬라이드 데이터 전송
Route::get('/api/getSlideData','ApiController@getSlideData')->name('getSlideData');


//DB::listen(function($query){
//	var_dump($query->sql);
//});
//
