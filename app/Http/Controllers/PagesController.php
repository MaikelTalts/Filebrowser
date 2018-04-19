<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Storage;
use Filebrowser\Folder;
use Filebrowser\Activity;
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
      //get current User
      $user = Auth::user();
      $userPrivileges = $user->user_privileges;

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
            $folder = Folder::orderBy('id', 'DESC')->first();
            $folderID = $folder->id;
            //dd($cur_ID);
            DB::table('folder_user')->insert([
              ['user_id' => 1, 'folder_id' => $folderID]
            ]);
          }
        }

      /*check if folders table contains name of old folders, that does not exist
        anymore, remove them from database.*/
      foreach($folders as $folder){
          $folderID = $folder->id;
          $name = $folder->folder_name;
          $directories = str_replace(env('ROOTFOLDER'), '', $directories );
          if(!in_array($name, $directories)) {
            DB::table('folder_user')->where('folder_id', '=', $folderID)->delete();
            $folder->delete();
          }
        }
        $userFolders = $user->folders;
        //Return to index page, with user ID, and folders from folders table.
        return view('pages.index')->with(['user' => $user, 'directories' => $userFolders]);
    }

  public function activity(){
      $userPrivilege = Auth::user()->user_privileges;
      if($userPrivilege != 2){
        return redirect('home');
      }
      //Get the 20 latest activities
      $activities = Activity::orderby('created_at', 'desc')->limit(20)->get();
      //Create rendered table row with each of those activities, that page will be used in ActivityController as well
      $activityList = View::make('pages.activityListing', ['activities' => $activities])->render();
      //Return activities page with recently created activity list
      return view('pages.activity')->with(['activities' => $activityList]);
  }

  public function show($directory){
      $directoryArray = array();
      $user = Auth::user();
      $userFolders = $user->folders;
      $currentDir = explode('/', $directory);
      //Create an array that contains folder names that current logged in user has access to
      foreach($userFolders as $folder){
        array_push($directoryArray, $folder->folder_name);
      }

      //Check if user is heading to /public or some other path, that doesn't actually exist. Redirect user to index
      if($directory == "public" || sizeof($currentDir) == 1){
        return redirect('/');
        }

      //If user has access into the folder that hes trying to get into return view with that specific directory
      if(in_array($currentDir[1], $directoryArray)){
        $directories = null;
        return view('pages.show', ['directory' => $directory])->with(['user' => $user, 'directories' => $directories]);
      }
      //If for some reason previous tests fail, return user back to index
      else{
        return redirect('/');

      }
    }

    public function settings(){
      $files = Storage::allFiles(env('ROOTFOLDER'));
      $fileAmount = count($files);
      $directories = Storage::allDirectories(env('ROOTFOLDER'));
      $directoryAmount = count($directories);
      //Check if current user has rights to enter the settins page
      if (Auth::user()->user_privileges == 2){
        //get all users from database
        $allUsers = User::all();
        $userAmount = count($allUsers);
        return view('pages.settings')->with(['users' => $allUsers, 'files' => $fileAmount, 'userAmount' => $userAmount, 'directories' => $directoryAmount]);
      }
      //If not, redirect back to index page
      else{
        return redirect('/');
      }
    }



}
