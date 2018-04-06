<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Filebrowser\User;
use Filebrowser\Folder;

class UserController extends Controller
{
  public function updateStatus(Request $request){
    //Check witch status was selected
    $userID = $request['userID'];
    //Check witch user was selected
    $selection = $request['statusSelection'];
    //Update selected users privilege status.
    DB::table('users')->where('id',$userID)->update(array('user_privileges'=>$selection));

    $user = User::find($userID);
    $userName = $user->name;
    //Return response
    if($selection == 1){
      $newUserStatus = "User";
      $notificationText = $userName . " " . "is now a user";
    }
    else{
      $newUserStatus = "<strong>Admin</strong>";
      $notificationText = $userName . " " . "is now an admin";
    }
    return response()->json([
      'notificationMessage' => $notificationText,
      'newUserStatus' => $newUserStatus,
      'success' => 'Succeed',
      'error'   => "Didn't work"
    ]);
  }

  public function deleteUser(Request $request){
    //Check witch user was selected
    $userID = $request['userID'];
    //Search user from database
    $user = User::find($userID);
    //Get the users name
    $userName = $user->name;
    //Poistetaan folder_user tietokantataulusta kaikki en tietueet, joissa poistettava käyttäjä esiintyy
    DB::table('folder_user')->where('user_id', '=', $userID)->delete();
    //Delete selected user from database
    User::where('id', $userID)->delete();
    //Create response message to show in the notification bar
    $notificationText = $userName . " has been deleted succesfully";
    //Return response
    return response()->json([
      'notificationMessage' => $notificationText,
      'success' => 'User was deleted',
      'error'   => 'Error'
    ]);
  }

  function updateFolderPrivileges(Request $request) {
    //Request the base variables
    $userID = $request['userID'];
    $folderID = $request['folderID'];
    //Search the user from database
    $user = User::find($userID);
    //Get the users name
    $userName = $user->name;
    //Search the folder from database
    $folder = Folder::find($folderID);
    //Get the folders named
    $folderName = $folder->folder_name;
    //Search if there already is a row in folder_user table with selected user and selected folder
    $user_folder_status = DB::table('folder_user')->where(
                            'user_id', '=', $userID)->where(
                            'folder_id', '=', $folderID)->first();
    //If user does not yet have access in selected folder remove the access.
    if($user_folder_status == null){
        DB::table('folder_user')->insert(
          ['user_id' => $userID, 'folder_id' => $folderID]);
          //Write a notification message
          $notificationMsg = $userName. " now has access to " . $folderName;
    }
    //If user already has access to selected folder, remove it
    else{
      DB::table('folder_user')->where(
        'user_id', '=', $userID)->where(
        'folder_id', '=', $folderID)->delete();
        //Write a notification message
        $notificationMsg = $userName . " has no longer access to " . $folderName;
    }
    //Return response
    return response()->json([
                'notificationMsg' => $notificationMsg,
                'error' => "Didn't work"
    ]);
  }

  function updateUplaodPrivilege(Request $request){
    //Request the base variables
    $userID = $request['userID'];
    $uploadSelection = $request['uploadSelection'];
    //Search the user from database
    $user = User::find($userID);
    //Get the users name
    $userName = $user->name;
    //Update users upload privileges
    User::where('id', $userID)->update(['user_upload_privilege' => $uploadSelection]);
    //Return response to ajax
    if($uploadSelection == 1){
      //Write a notification message
      $notificationMsg = $userName . " can no longer upload files";
    }
    else{
      //Write a notification message
      $notificationMsg = $userName . " can now upload files";
    }
    return response()->json([
                'notificationMsg' => $notificationMsg,
                'success' => "Changed",
                'error' => "Didn't work"
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
      'error' => "Didn't work"
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
      return response()->json([
        'changeFailed' => 'ChangeFailed',
        ]);
    }

    //Return response
    return response()->json([
      'newName' => $userName,
      'success' => "Changed",
      'error' => "Failed"
    ]);
  }

}
