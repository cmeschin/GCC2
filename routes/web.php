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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    // All my routes that needs a logged in user
    Route::get('home', 'HomeController@index')->name('home');

    Route::get('nouvelledemande', 'NouvelleDemandeController@initialisation')->name('infosgenerales');

    Route::post('nouvelledemande/{refdemande}/selection', 'NouvelleDemandeController@selection')->name('selection');

    Route::post('nouvelledemande/{refdemande}/parametrage', 'NouvelleDemandeController@parametrage')->name('parametrage');

    Route::post('nouvelledemande/{refdemande}/validation', 'NouvelleDemandeController@validation')->name('validation');

    Route::get('moncompte', 'HomeController@account')->name('moncompte');

    Route::get('accounts', 'HomeController@accountsManagment')->name('accountsManagment');

    Route::post('account/{userid}/setaccount', 'AccountController@setAccount')->name('setaccount');

    Route::post('account/{userid}/delaccount', 'AccountController@delAccount')->name('delaccount');

    Route::post('account/{userid}/addpreference', 'AccountController@addPreference')->name('addpreference');

    Route::post('account/{userid}/delpreference/{preferenceid}', 'AccountController@delPreference')->name('delpreference');

    Route::post('/parametrage/service_delete/{serviceid}', 'NouvelleDemandeController@deleteService')->name('delservice');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});


