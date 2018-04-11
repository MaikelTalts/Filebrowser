<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
  //Checks if user has selected a file to send.
  if($request->hasFile('file')){
    //Check if file is any of following file types
    $this->validate($request, [
      'file'  => 'required|mimetypes:image/jpeg,image/png,
      image/jpg,image/gif,image/svg+xml,text/plain|max:2048',
    ]);
    //Get the content of hidden form input (path).
    $polku = $request->invisible;
    //Save the file to variable
    $file = $request->file('file');
    //Get the files original name
    $filename = $file->getClientOriginalName();
    //Save the file into the received path variable with the files original name
    $request->file('file')->storeAs($polku, $filename);
    //Return the user back to where he was (Refresh page)
    return back()->with('success', 'Tiedoston lähetys onnistui');
  }
  //If user did not select file to upload, refresh page and send error notification
  else {
    return back()->with('error', 'Valitse lähetettävä tiedosto');
  }
}

public function delete($file){
  //Deletes the file that it received.
  Storage::delete($file);
  //Updates page and shows notification about the successful deleton.
  return back()->with('delete', 'Tiedoston poisto onnistui');
}

public function rename(Request $request){
  //Array that contains letters that will be replaced
$search = array("Å","å","Ä","ä","Ö","ö", " ");
  //Variable that contains letters that will replace the previous arrays letters
$replace = array("A","a","A","a","O","o", "_");

  //Variable that receives old file name
$old_name = $request['OldName'];
  //Variable that receives new file name
$new_name = $request['NewName'];

//Check and remove letters from new file name
$new_name = str_replace($search, $replace, $new_name);
//Checks and removes all special characters from the new file name
$result = preg_replace('/[^a-zA-Z0-9-_\/.]/','', $new_name);

//Moves the file back to its current location with new name
Storage::move($old_name,$result);
$newFileNameExpl = explode("/", $result);
$newFileName = end($newFileNameExpl);
//Returns ajax response if the rename was successful or not, new name and old name
return response()->json([
            'old_name' => $old_name,
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
