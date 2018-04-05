<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Filebrowser\User;

class UserController extends Controller
{
  public function privilege(Request $request){
    //Check witch status was selected
    $selection = $request['selected'];
    //Check witch user was selected
    $user = $request['userId'];
    //Update selected users privilege status.
    DB::table('users')->where('id',$user)->update(array('user_privileges'=>$selection));
    //Return response
    return response()->json([
      'success' => 'Onnistui',
      'error'   => 'Epäonnistui'
    ]);
  }

  public function deleteUser(Request $request){
    //Check witch user was selected
    $user = $request['userId'];
    //Delete selected user from database
    DB::delete('delete from users where id = ?', [$user]);
    //Return response
    return response()->json([
      'success' => 'User was deleted',
      'error'   => 'Error'
    ]);
  }

  function directory_user(Request $request) {
    //Check witch user was selected
    $user = $request['userId'];
    //Select all folders where selected user had access to
    $userFolders = DB::select('select * from folder_user where user_id = ?', [$user]);
    //Select database row of selected user
    $selectedUser = DB::table('users')->where('id', $user)->first();
    //Create array variable
    $data = array();
    //If $userFolders array contains info, push the folder id to array
    if($userFolders){
      foreach($userFolders as $folder){
        array_push($data, $folder->folder_id);
      }
    }
    //Select all folders in folders table
    $directories = DB::select('select * from folders');
    //Create page with variable contents and pass it to Jquery
    $createContent = View::make('pages.user_directorylist', ['data' => $data, 'directories' => $directories, 'user' => $user, 'selectedUser' => $selectedUser])->render();
    return response()->json([
                'success'  => $createContent,
                'error'    => "Virhe kansiota luodessa"
            ]);
  }

  function updateFolderPrivileges(Request $request) {
    //Check witch user was selected
    $user = $request['userID'];
    //Check witch folder was clicked
    $folder = $request['folderID'];
    //Search if there already is a row in folder_user table with selected user and selected folder
    $user_folder_status = DB::table('folder_user')->where(
                            'user_id', '=', $user)->where(
                            'folder_id', '=', $folder)->first();
    //If user does not yet have access in selected folder remove the access.
    if($user_folder_status == null){
        DB::table('folder_user')->insert(
          ['user_id' => $user, 'folder_id' => $folder]);
          $returnMsg = "Lisätty";
    }
    //If user already has access to selected folder, remove it
    else{
      DB::table('folder_user')->where(
        'user_id', '=', $user)->where(
        'folder_id', '=', $folder)->delete();
        $returnMsg = "Poistettu";
    }
    //Return response
    return response()->json([
                'success' => $returnMsg,
                'error' => "Ei toimi"
    ]);
  }

  function updateUploadPrivilege(Request $request){
    //Receive user's ID
    $userID = $request['userID'];
    //Search user from database
    $user = DB::table('users')->where('id', $userID)->first();
    //Select user_upload_privilege status
    $userUploadStatus= $user->user_upload_privilege;

    //Check if user does not yet have premission to upload files, if not give premission
    if($userUploadStatus == 1){
    DB::table('users')->where('id', $userID)->update(['user_upload_privilege' => 2]);
    }
    //If it does, remove premission
    else{
    DB::table('users')->where('id', $userID)->update(['user_upload_privilege' => 1]);
    }
    //Return response messages
    return response()->json([
                'success' => "Muutettu",
                'error' => "Ei Toimi"
    ]);
  }

  function printUserPage(Request $request){
    $userID = $request['userID'];
    $user = User::find($userID);
    $userFolders = DB::select('select * from folder_user where user_id = ?', [$userID]);
    $dirArray = array();
    //If $userFolders array contains info, push the folder id to array
    if($userFolders){
      foreach($userFolders as $folder){
        array_push($dirArray, $folder->folder_id);
      }
    }
    $directories = DB::select('select * from folders');
    $userPageContent = View::make('pages.userControlModal', ['user' => $user, 'dirArray' => $dirArray, 'directories' => $directories])->render();
    return response()->json([
      'success' => $userPageContent,
      'error' => "Ei toimi"
    ]);
  }
}
