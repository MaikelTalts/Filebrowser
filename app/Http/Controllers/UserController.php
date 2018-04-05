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
  public function updateStatus(Request $request){
    //Check witch status was selected
    $user = $request['userID'];
    //Check witch user was selected
    $selection = $request['statusSelection'];
    //Update selected users privilege status.
    DB::table('users')->where('id',$user)->update(array('user_privileges'=>$selection));
    //Return response
    if($selection == 1){
      $newUserStatus = "User";
    }
    else{
      $newUserStatus = "<strong>Admin</strong>";
    }
    return response()->json([

      'newUserStatus' => $newUserStatus,
      'success' => 'Onnistui',
      'error'   => 'Epäonnistui'
    ]);
  }

  public function deleteUser(Request $request){
    //Check witch user was selected
    $userID = $request['userID'];
    //Delete selected user from database
    User::where('id', $userID)->delete();
    //Return response
    return response()->json([
      'success' => 'User was deleted',
      'error'   => 'Error'
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

  function updateUplaodPrivilege(Request $request){
    //Request user's ID
    $userID = $request['userID'];
    //Request upload status selection
    $uploadSelection = $request['uploadSelection'];
    //Update users upload privileges
    User::where('id', $userID)->update(['user_upload_privilege' => $uploadSelection]);
    //Return response to ajax
    return response()->json([
                'success' => "Muutettu",
                'error' => "Ei Toimi"
    ]);
  }

  function printUserPage(Request $request){
    //Request user's ID
    $userID = $request['userID'];
    //Select user that has the same id as requested
    $user = User::find($userID);
    //Select all folders that user has access to
    $userFolders = DB::select('select * from folder_user where user_id = ?', [$userID]);
    //Create array to add folder ID's
    $dirArray = array();
    //If $userFolders array contains info, push the folder id to array
    if($userFolders){
      foreach($userFolders as $folder){
        array_push($dirArray, $folder->folder_id);
      }
    }
    //Select all folders that has been listed in folders database table
    $directories = DB::select('select * from folders');
    //Create view to return for ajax
    $userPageContent = View::make('pages.userControlModal', ['user' => $user, 'dirArray' => $dirArray, 'directories' => $directories])->render();

    return response()->json([
      'success' => $userPageContent,
      'error' => "Ei toimi"
    ]);
  }

  function updateUserInfo(Request $request){
    //Request user's ID
    $userID = $request['userID'];
    //Request user's name
    $name = $request['userName'];
    //Request user's email
    $userEmail = $request['userEmail'];
    //Trim spaces from beginning and end of string
    $userName = trim($name);
    if($userName != null && $userName != ""){
      //Update selected user with requested data
      User::where('id', $userID)->update(['name' => $userName, 'email' => $userEmail]);
    }
    else{
      $userName = "Eitoiminut";
    }

    //Return response
    return response()->json([
      'newName' => $userName,
      'success' => "Changed",
      'error' => "Failed"
    ]);
  }

}
