<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
  public function privilege(Request $request){
    $selection = $request['selected'];
    $user = $request['userId'];

    DB::table('users')->where('id',$user)->update(array('user_privileges'=>$selection));

    return response()->json([
      'success' => 'Onnistui',
      'error'   => 'Epäonnistui'
    ]);
  }

  public function deleteUser(Request $request){
    $user = $request['userId'];
    DB::delete('delete from users where id = ?', [$user]);

    return response()->json([
      'success' => 'User was deleted',
      'error'   => 'Error'
    ]);

    /*DELETE FROM table_name
    WHERE condition; */
  }

  function directory_user(Request $request) {
    // diipadaapaa
    $user = $request['userId'];
    $userFolders = DB::select('select * from folder_user where user_id = ?', [$user]);
    $selectedUser = DB::table('users')->where('id', $user)->first();
    $data = array();
    if($userFolders){
      foreach($userFolders as $folder){
        array_push($data, $folder->folder_id);
      }
    }
    $directories = DB::select('select * from folders');//Folder::all();

    $testi = View::make('pages.user_directorylist', ['data' => $data, 'directories' => $directories, 'user' => $user, 'selectedUser' => $selectedUser])->render();
    return response()->json([
                'success'  => $testi,
                'error'    => "Virhe kansiota luodessa"
            ]);

  }

  function updateFolderPrivileges(Request $request) {
    $user = $request['userID'];
    $folder = $request['folderID'];

    $user_folder_status = DB::table('folder_user')->where(
                            'user_id', '=', $user)->where(
                            'folder_id', '=', $folder)->first();

    if($user_folder_status == null){
        DB::table('folder_user')->insert(
          ['user_id' => $user, 'folder_id' => $folder]);
          $returnMsg = "Lisätty";
    }
    else{
      DB::table('folder_user')->where(
        'user_id', '=', $user)->where(
        'folder_id', '=', $folder)->delete();
        $returnMsg = "Poistettu";
    }
    return response()->json([
                'success' => $returnMsg,
                'error' => "Ei toimi"
    ]);
  }

}
