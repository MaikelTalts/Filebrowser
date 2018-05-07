<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filebrowser\Activity;
use Filebrowser\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Filebrowser\Folder;
use app\Download;
use Storage;

class FileController extends Controller
{
  /**
      * Update the avatar for the user.
      *
      * @param  Request  $request
      * @return Response
      */

//Upload function
public function upload(Request $request){
  $userName = Auth::user()->name;
  $currentUser = Auth::user();
  $token = $request->input('_token');
  //Checks if user has selected a file to send.
  if($request->hasFile('file')){
    //Check if file is any of following file types
    $this->validate($request, [
      'file'  => 'required|mimetypes:image/jpeg,image/png,
      image/jpg,image/gif,image/svg+xml,text/plain|max:2048',
    ]);
    //Get the content of hidden form input (path).
    $path = $request->invisible;
    //Save the file to variable
    $file = $request->file('file');
    //Get the files original name
    $fileName = $file->getClientOriginalName();
    //Save the file into the received path variable with the files original name
    $request->file('file')->storeAs($path, $fileName);
    //Create new activity log
    app('Filebrowser\Http\Controllers\ActivityController')->updateActivityLog($userName, "uploaded", "file", $fileName, "in", $path);
    //Return the user back to where he was (Refresh page)
    $fileRender = View::make('pages.file', ['fileName' => $fileName, 'path' => $path . "/" . $fileName, 'user' => $currentUser])->render();
    return response()->json([
      'success' => $fileRender
    ]);
  }
  //If user did not select file to upload, refresh page and send error notification
  else {
    return response()->json([
      'error' => 'Did not work'
    ]);
  }
}

public function delete($file){
  $user = Auth::user();
  //Explode the filepath
  $fileExpl = explode("/", $file);
  //Get the folder

  if(sizeof($fileExpl) == 2){
    if($user->user_privileges == 2){
      $this->deletion($fileExpl, $file, $user);
      return back()->with('delete', 'Tiedoston poisto onnistui');
    }
    else{
      return redirect("/")->with('error', 'You do not have rights to delete files of folders');
    }
  }
  else{
    $folder = Folder::where('folder_name', '=' , $fileExpl[1])->first();
    //Get the folder's ID
    $folderID = $folder->id;
    //Check if current user has access into a selected directory
    if(DB::table('folder_user')->where('folder_id', '=', $folderID)->where('user_id', '=', $user->id)->exists()){
      $this->deletion($fileExpl, $file, $user);
      return back()->with('delete', 'Tiedoston poisto onnistui');
    }
    else{
      return redirect("/")->with('error', 'You do not have access to this directory');
    }
  }
}

public function deletion($fileExpl, $file, $user){
  //Use the last element in exploded array
  $fileName = end($fileExpl);
  //Remove the filename from received filepath to get the directory
  $filepath = str_replace($fileName, "", $file);
  //Deletes the file that it received.
  Storage::delete($file);
  //Insert activity
  app('Filebrowser\Http\Controllers\ActivityController')->updateActivityLog($user->name, "deleted", "file", $fileName, "from", $filepath);
  //Updates page and shows notification about the successful deleton.
  return;
}

public function rename(Request $request){
//Get the current logged in user's name
$userName = Auth::user()->name;
  //Array that contains letters that will be replaced
$search = array("Å","å","Ä","ä","Ö","ö", " ");
  //Variable that contains letters that will replace the previous arrays letters
$replace = array("A","a","A","a","O","o", "_");

  //Variable that receives old file name
$oldName = $request['OldName'];
  //Variable that receives new file name
$newName = $request['NewName'];

//Explode the old filename (as it is path to the file)
$oldFileExpl = explode("/", $oldName);
//Use the last element in exploded array
$oldFileName = end($oldFileExpl);
//Check and remove letters from new file name
$newName = str_replace($search, $replace, $newName);
//Checks and removes all special characters from the new file name
$result = preg_replace('/[^a-zA-Z0-9-_\/.]/','', $newName);

//Moves the file back to its current location with new name
Storage::move($oldName,$result);
$newFileNameExpl = explode("/", $result);
$newFileName = end($newFileNameExpl);

app('Filebrowser\Http\Controllers\ActivityController')->updateActivityLog($userName, "renamed", "file", $oldFileName, "as", $newFileName);
//Returns ajax response if the rename was successful or not, new name and old name
return response()->json([
            'old_name' => $oldName,
            'new_path' => $result,
            'new_name' => $newFileName,
            'success'  => "Nimi muutettu onnistuneesti",
            'error'    => "Virhe nimen muutossa"
        ]);
}

public function download($file) {
  //Starts download with the received file
return response()->download(storage_path('app/').$file);
}

}
