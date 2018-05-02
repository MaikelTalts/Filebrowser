<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Filebrowser\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
use Filebrowser\Activity;
use Illuminate\Support\Facades\DB;
use Storage;
use Filebrowser\Folder;
use ZipArchive;
use Chumper\Zipper\Facades\Zipper;

class DirectoryController extends Controller
{
  public function __construct(){
      $this->middleware('auth');
  }

  public function deleteDirectory($directory){
    if(Auth::user()->user_privileges == 2){
      $userName = Auth::user()->name;
      $directoryExpl = explode("/", $directory);
      $directoryName = end($directoryExpl);
      $directoryPath = str_replace($directoryName, "", $directory);
      //Delete fysical directory that has same path and name witch was received.
      Storage::deleteDirectory($directory);
      //Create new acitivity log mark
      app('Filebrowser\Http\Controllers\ActivityController')->updateActivityLog($userName, "deleted", "directory", $directoryName, "in", $directoryPath);
      //Split the directorypath into separate directories
      $explodeDirectory = explode("/", $directory);
      //Check how long is the directory path
      $pathLenght = count($explodeDirectory);
      //If the directory path is same as 2, witch means that the directory that we are deleting is located inside public, then remove the folder from database as well.
      if($pathLenght == 2){
        $directory = end($explodeDirectory);
        //Get folders id, so that it can also be removed from folder_user table
        $directoryId = Folder::where('folder_name', '=' , $directory)->first()->id;
        //Delete folder from folder_user table
        DB::table('folder_user')->where('folder_id', '=', $directoryId)->delete();
        //Delete folder from folders table
        Folder::where('folder_name', '=' , $directory)->delete();
        //Needs to be changed to ajax call!! (Works, but ugly AF)
      }
      return back();
    }
    else{
      return redirect('/');
    }
  }


  function createDirectory(Request $request){
    $userName = Auth::user()->name;
    $userID = Auth::user()->id;
    //Receive given filename and selected location.
    $directoryName = $request['dir_name'];
    $creationDirectory = $request['creation_dir'];

    /*Create comparin array that includes nordic letters, and array that
      includes replacement letters*/
    $search = array("Å","å","Ä","ä","Ö","ö", " ");
    $replace = array("A","a","A","a","O","o", "_");

    //Remove nordic letters and special characters from the name:
    $fixedName= str_replace($search, $replace, $directoryName);
    $name = preg_replace('/[^a-zA-Z0-9-_\/.]/','', $fixedName);

    //Create fysical directory in selected place.
    Storage::makeDirectory($creationDirectory."/".$name);
    //Create new acitivity log mark
    app('Filebrowser\Http\Controllers\ActivityController')->updateActivityLog($userName, "created", "directory", $directoryName, "in", $creationDirectory);

    //If creation directory is public, add the directoryname into database, and give access for that specific directory for logged in user and admin.
    if($creationDirectory == "/public"){
    Folder::create([
      'folder_name' => $name
    ]);
        //Fetch the ID of previously created folder.
        $folder = Folder::orderBy('id', 'DESC')->first();
        $folderId = $folder->id;

        /*Create new row on [folder_user] table, that automatically gives Admin
          privileges on every created folder*/
        DB::table('folder_user')->insert([
          ['user_id' => 1, 'folder_id' => $folderId],
        ]);
        //Check if the user is NOT admin, then give permission to that folder for him as well.
        if($userID != 1){
          DB::table('folder_user')->insert([
            ['user_id' => $userID, 'folder_id' => $folderId],
          ]);
        }
  }

    $dirElement = "<li class='list-group-item clearfix folder'>
                      <div class='row item-vertical-center'>
                          <div class='col-xs-7'>
                              <span class='folderIcon'><i class='far fa-folder'></i></span>
                              <a href='$creationDirectory/$name'><span>$name</span></a>
                          </div>
                          <div class='col-xs-5 itemButtons'>
                              <a href='/download-zip$creationDirectory/$name' class='btn btn-success itemBtn' role='button'><i class='fas fa-download'></i></a>
                              <a href='/delete-folder$creationDirectory/$name' class='btn btn-danger itemBtn' role='button'><i class='far fa-trash-alt'></i></a>
                          </div>
                      </div>
                  </li>";

    //Send response if the function was successful or not.
    return response()->json([
                'append' => $dirElement,
                'success'  => "Kansio luotu onnistuneesti",
                'error'    => "Virhe kansiota luodessa"
            ]);
  }

  function downloadDirectory($directory) {
    //Explode the received directory, to get first and last directory
    $explodeDirectory = explode("/",$directory);
    //Select the folder from database by its name
    $folder = Folder::where('folder_name', '=' , $explodeDirectory[1])->first();
    //Get the folder's ID
    $folderID = $folder->id;
    //Select current system user from database
    $user = Auth::user();
    //Select current user's ID
    $userID = $user->id;
    //Check if current user has access into a selected directory
    if(DB::table('folder_user')->where('folder_id', '=', $folderID)->where('user_id', '=', $userID)->exists()){
      $name = end($explodeDirectory);
      //Define new zipper
      $zipper = new Zipper;
      //Check all files and folders in received directory
      $files = storage_path('app/' . $directory);
      //Create new zip with the directory name and add all files that were doind into it.
      $zipper = Zipper::make($name . ".zip")->folder($name)->add($files)->close();
      //Check if the zip file exists, (if selected directory is empty, it wont create zip)
      if(file_exists($name . ".zip")){
        //Return the zip file download as resut, and delete it from system folder after that.
        return response()->download(public_path("/") . $name . ".zip")->deleteFileAfterSend(true);
      }
      else{
        return back()->with('error', 'Directory is empty');;
      }
    }
    else{
      return redirect('/')->with('error', 'You do not have access to this directory');
    }


  }

}
