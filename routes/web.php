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

Route::get('auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();
// Route::get('/login', '');

Route::get('/', [
  'middleware' => 'auth',
  'uses' => 'PagesController@index'       //Head to root = /public directory
]);

Route::get('/settings', 'PagesController@settings');          //Head to view pages/settings.blade.php

Route::get('/activity', 'PagesController@activity');      //Shows filebrowser's activity feed.

Route::post('/update-status', ['uses'=>'UserController@updateStatus','as'=>'updateUserStatus']);   //Update selected user's status (Admin or User)

Route::post('/load-more-activities', 'ActivityController@loadMoreActivities');      //Load more activities to activity page

Route::post('/delete-user', ['uses'=>'UserController@deleteUser','as'=>'DeleteUser']);           //Delete selected user

Route::post('/update-user-folder-privileges', 'UserController@updateFolderPrivileges');     //update selected users folder privileges (checkbox)

Route::post('/pring-user-page', 'UserController@printUserPage');            //Print selected users setting page

Route::post('/show-user-settings', 'UserController@showUserSettings');      //If the logged in user is someone else than admin, then show current user's settings modal

Route::post('update-user-info', 'UserController@updateUserInfo');           //Update current user name & email

Route::post('/update-user-password', 'UserController@updateUserPassword');

Route::post('/update-upload-privileges', 'UserController@updateUploadPrivilege');     //Update current user's upload privileges

Route::get('download/{file}', 'FileController@download')                  //Download selected file
  ->where(['file' => '.*']);

Route::post('/rename', ['uses'=>'FileController@rename','as'=>'rename']);     //Renames current file with the inserted name

Route::post('upload', 'FileController@upload');                           //Uploads selected file to filebrowser

Route::post('/create-directory', ['uses'=>'DirectoryController@createDirectory','as'=>'createDirectory']);      //Creates directory with inserted name

Route::get('delete/{file}', ['uses' => 'FileController@delete'])        //Deletes selected file
  ->where(['file' => '.*']);

  Route::get('download-zip/{directory}', ['uses' => 'DirectoryController@downloadDirectory'])    //Downloads selected directory and all it's content as zip file.
    ->where(['directory' => '.*']);

Route::get('delete-folder/{directory}', 'DirectoryController@deleteDirectory')      //Deletes selected directory from filebrowser
  ->where(['directory' => '.*']);

Route::get('{directory}', ['uses' => 'PagesController@show'])             //Clicked directory will print pages/show.blade.php page with selected directory path
  ->where(['directory' => '.*']);
