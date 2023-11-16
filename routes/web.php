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

Route::get('/', 'HomeController@landing');
Route::get('/home', 'InvoiceController@index');
Route::get('/invoice/tambah', 'InvoiceController@create');
Route::post('/invoice/store', 'InvoiceController@store');
Route::get('/layanan', 'ServiceController@index');
Route::get('/layanan/tambah', 'ServiceController@create');
Route::post('/layanan/store', 'ServiceController@store');
Route::get('/layanan/{service}/edit', 'ServiceController@edit');
Route::get('/invoice/{invoice}/edit', 'InvoiceController@edit');
Route::get('/invoice/{invoice}/show', 'InvoiceController@show');
Route::put('/layanan/{service}/update', 'ServiceController@update');
Route::delete('/layanan/{service}', 'ServiceController@destroy')->name('service.destroy');
Route::put('/invoice/{invoice}/update', 'InvoiceController@update');
Route::delete('/invoice/{invoice}', 'InvoiceController@destroy')->name('invoice.destroy');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
