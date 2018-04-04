<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Storage;
use Filebrowser\Folder;
use Filebrowser\User;
//use Illuminate\Foundation\Auth\User;
use Filebrowser\folder_user;
use Illuminate\Http\Redirect;

class PagesController extends Controller
{
  // Varmisetaan etä käyttäjä on sivulla liikkuessaan kirjautunut sisälle.
  public function __construct(){
      $this->middleware('auth');
  }

  // web.php siirtäessä PagesController@index, aloitetaan funktio "index", joka palauttaa käyttäjälle index.php sivun näkymän.
  public function index(){
    //get current User name and ID
    $user_name = Auth::user()->name;
    $user_id = Auth::user()->id;
    $userPrivileges = Auth::user()->user_privileges;
    //Search user from database with user_ID
    $user = User::find($user_id);

    /*Get fysical directories with value of global variable and all folders
      that have been listed in table*/
    $directories = Storage::Directories(env('ROOTFOLDER'));
    $folders = Folder::all();

    /*Loop all fysical directories through and if it does not already exist
      in folders table, create it*/
    foreach($directories as $directory){
      //Remove the rootfolder text from the original name
      $directory = str_replace(env('ROOTFOLDER'), '', $directory);
      //check if directory is in folders collection
      $exists = $folders->filter(function($item) use($directory) {
        return $item->folder_name == $directory;
      })->first();
      //If the folder does not exist in database, create one.
      if(!$exists) {
        Folder::create([
          'folder_name' => $directory
        ]);
        /*Get the ID of previously created folder in table, and create new
          folder_table with that ID*/
        $folder_id = Folder::orderBy('id', 'DESC')->first();
        $cur_ID = $folder_id->id;
        //dd($cur_ID);
        DB::table('folder_user')->insert([
          ['user_id' => 1, 'folder_id' => $cur_ID]
        ]);
      }
    }

    /*check if folders table contains name of old folders, that does not exist
      anymore, remove them from database.*/
    foreach($folders as $folder){
      $name = $folder->folder_name;
      $directories = str_replace(env('ROOTFOLDER'), '', $directories );
      if(!in_array($name, $directories)) {
        $folder->delete();
      }
    }
      $user_folders = $user->folders;
      //Return to index page, with user ID, and folders from folders table.
      return view('pages.index')->with(['user' => $user, 'directories' => $user_folders]);
    }


  public function show($directory){
    $directoryArray = array();
    $user = Auth::user()->name;
    $userID = Auth::user()->id;
    $currentUser = User::find($userID);
    $user_folders = $currentUser->folders;
    $userPrivileges = Auth::user()->user_privileges;
    $allDirectories = Storage::Directories(env('ROOTFOLDER'));


    //Check if user is heading to /public, if so, redirect him back to inxex (as it has the same content).
    if($directory == "public"){
      return redirect('/');
      }

    else{
      //Check where the user is heading to. Check if the user is allowed to move inside the second directory in the folder path.
      //If user is allowed open received directory for user. If user is not allowed to enter that directory, return to index.
      $currentDir = explode('/', $directory);
      if(sizeof($currentDir) == 1){
        return redirect('/');
      }
      foreach($user_folders as $folder){
        array_push($directoryArray, $folder->folder_name);
      }

      if(in_array($currentDir[1], $directoryArray)){
        $directories = null;
        return view('pages.show', ['directory' => $directory])->with(['user' => $currentUser, 'userPrivileges' => $userPrivileges, 'directories' => $directories]);
      }
      else{
        return redirect('/');

      }
    }
    return redirect('/');
      //return view('pages.show', ['directory' => $directory])->with(['user' => $user, 'userPrivileges' => $userPrivileges, 'directories' => $directoryArray]);
    }

    public function settings(){
      $usersi = User::all();
      $directories = Folder::all();
      //Check if current user has rights to enter the settins page
      if (Auth::user()->user_privileges == 2){
        $user = DB::table('users')->get();
        return view('pages.settings')->with(['user' => $user, 'usersi' => $usersi, 'directories' => $directories]);
      }
      //If not, redirect back to index page
      else{
        return view('pages.index');
      }
    }

}
