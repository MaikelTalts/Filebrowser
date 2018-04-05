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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

Auth::routes();
// Route::get('/login', '');

Route::get('/', [
  'middleware' => 'auth',
  'uses' => 'PagesController@index'
]);                                                                       //Osoitepyyntö "/" , aloittaa funktion "index" --> PagesController

Route::get('/settings', 'PagesController@settings');

Route::post('/update-privilege', ['uses'=>'UserController@privilege','as'=>'updatePrivilege']);   //Käyttäjien oikeuksien muuttaminen

Route::post('/delete-user', ['uses'=>'UserController@deleteUser','as'=>'DeleteUser']);           // Käyttäjän poisto

Route::post('/user-directory-privileges', 'UserController@directory_user');

Route::post('/update-user-folder-privileges', 'UserController@updateFolderPrivileges');

Route::post('/pring-user-page', 'UserController@printUserPage');

Route::post('/update-upload-privileges', 'UserController@updateUplaodPrivilege');

Route::get('download/{file}', 'FileController@download')                  //Osoitepyyntö, "/download" aloittaa funkton "download" --> FileController
  ->where(['file' => '.*']);

Route::post('/rename', ['uses'=>'FileController@rename','as'=>'rename']);

Route::post('upload', 'FileController@upload');                           //Osoitepyyntö "/upload", aloittaa funktion "upload" --> FileController

Route::post('/create-directory', ['uses'=>'DirectoryController@createDirectory','as'=>'createDirectory']);

Route::get('delete/{file}', ['uses' => 'FileController@delete'])          //Osoitepyyntö "Mikä tahansa tiedostopolku", aloittaa funktion show --> FileController ja lähettää mukaan kyseisen tiedostopolun.
  ->where(['file' => '.*']);

  Route::get('download-zip/{directory}', ['uses' => 'DirectoryController@downloadDirectory'])    //Osoitepyyntö "download-zip/{directory}" pakkaa valitun valitun kansion sisällön zip tiedostoon ja  aloittaa lähetyksen järjestelmän käyttäjälle.
    ->where(['directory' => '.*']);

Route::get('delete-folder/{directory}', 'DirectoryController@deleteDirectory')      //Osoitepyyntö "delete-folder/{directory}" poistaa vastaanotetun tiedostopolun mukaisen kansion järjestelmästä.
  ->where(['directory' => '.*']);

Route::get('{directory}', ['uses' => 'PagesController@show'])             //Osoitepyyntö "Mikä tahansa tiedostopolku", aloittaa funktion show --> PagesController ja lähettää mukaan kyseisen tiedostopolun.
  ->where(['directory' => '.*']);

Route::get('/home', 'PagesController@index');
