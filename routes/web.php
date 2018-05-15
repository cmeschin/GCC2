<?php

use App\Http\Controllers\HomeController;

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

Route::get('home', 'HomeController@index')->name('home');

Route::get('nouvelledemande', 'NouvelleDemandeController@initialisation')->name('infosgenerales');

Route::get('moncompte', 'HomeController@account')->name('moncompte');

Route::post('nouvelledemande/{refdemande}', 'NouvelleDemandeController@selection')->name('selection');

Route::post('moncompte', 'HomeController@addpreference')->name('addpreference');

Route::post('delpreference/{id}', 'HomeController@delpreference')->name('delpreference');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


