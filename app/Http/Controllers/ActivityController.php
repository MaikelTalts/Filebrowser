<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Activity;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Filebrowser\User;

class ActivityController extends Controller
{
    //

    public function loadMoreActivities(Request $request){
      $amount = $request['amount'];
      $activities = Activity::orderby('created_at', 'desc')->limit($amount)->get();
      $activityList = View::make('pages.activityListing', ['activities' => $activities])->render();
      return response()->json([
        'success' => $activityList,
        'error' => "No eipäs toimi perkele :D"
      ]);
    }
}
