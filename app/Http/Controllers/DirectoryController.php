<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Filebrowser\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
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
    $user = Auth::user()->name;
    //Delete fysical directory that has same path and name witch was received.
    Storage::deleteDirectory($directory);
    //Split the directorypath into separate directories
    $explodeDirectory = explode("/", $directory);
    //Check how long is the directory path
    $pathLenght = count($explodeDirectory);
    //If the directory path is same as 2, witch means that the directory that we are deleting is located inside public, then remove the folder from database as well.
    if($pathLenght == 2){
      $directory = end($explodeDirectory);
      //Get folders id, so that it can also be removed from folder_user table
      $directory_id = Folder::where('folder_name', '=' , $directory)->first()->id;
      //Delete folder from folders table
      $db_dir = Folder::where('folder_name', '=' , $directory)->delete();
      //Delete folder from folder_user table
      DB::table('folder_user')->where('folder_id', '=', $directory_id)->delete();
      //Needs to be changed to ajax call!! (Works, but ugly AF)
  }
    return back();
  }


  function createDirectory(Request $request){
    //Receive given filename and selected location.
    $directory_name = $request['dir_name'];
    $creation_directory = $request['creation_dir'];

    /*Create comparin array that includes nordic letters, and array that
      includes replacement letters*/
    $search = array("Å","å","Ä","ä","Ö","ö", " ");
    $replace = array("A","a","A","a","O","o", "_");

    //Remove nordic letters and special characters from the name:
    $fixed_name = str_replace($search, $replace, $directory_name);
    $name = preg_replace('/[^a-zA-Z0-9-_\/.]/','', $fixed_name);

    //Create fysical directory in selected place.
    Storage::makeDirectory($creation_directory."/".$name);
    //Create the folder also in database [Folders] table.

    //If creation directory is public, add the directoryname into database, and give access for that specific directory for logged in user and admin.
    if($creation_directory == "public"){
    Folder::create([
      'folder_name' => $name
    ]);
        //Fetch the ID of previously created folder.
        $folder_id = Folder::orderBy('id', 'DESC')->first();
        $cur_ID = $folder_id->id;

        /*Create new row on [folder_user] table, that automatically gives Admin
          privileges on every created folder*/
          $user_name = Auth::user()->name;
          $user_id = Auth::user()->id;
        DB::table('folder_user')->insert([
          ['user_id' => 1, 'folder_id' => $cur_ID],
        ]);
        //Check if the user is NOT admin, then give permission to that folder for him as well.
        if($user_name != "admin"){
          DB::table('folder_user')->insert([
            ['user_id' => $user_id, 'folder_id' => $cur_ID],
          ]);
        }
  }
    //Send response if the function was successful or not.
    return response()->json([
                'success'  => "Kansio luotu onnistuneesti",
                'error'    => "Virhe kansiota luodessa"
            ]);
  }

  function downloadDirectory($directory) {
    //Explode the received directory path to get the actual directory name
    $path = explode("/",$directory);
    $name = end($path);
    //Define new zipper
    $zipper = new Zipper;
    //Check all files and folders in received directory
    $files = storage_path('app/' . $directory);
    //Create new zip with the directory name and add all files that were doind into it.
    $zipper = Zipper::make('public/' . $name . ".zip")->folder($name)->add($files)->close();
    //Return the zip file download as resut, and delete it from system folder after that.
    return response()->download(public_path('public/') . $name . ".zip")->deleteFileAfterSend(true);
  }

}
