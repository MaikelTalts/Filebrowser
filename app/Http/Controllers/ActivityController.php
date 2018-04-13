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
      //Get the amount of activities that should be loaded
      $amount = $request['amount'];
      //Get the amount of activities
      $activities = Activity::orderby('created_at', 'desc')->limit($amount)->get();
      //Get the amount of activities
      $allActivities = Activity::count();
      //Check the remainder of activities divided by 10
      $remainder = $allActivities - $amount;
      //If it is something else than 0, set variable to true and the Load More button wil be hidden
      if($remainder <= 0){
        $hideButton = true;
      }
      else{
        $hideButton = false;
      }
      //Render table list of activities
      $activityList = View::make('pages.activityListing', ['activities' => $activities])->render();
      //Return the rendered table list back to ajax for it to insert into tablebody
      return response()->json([
        'success' => $activityList,
        'hideButton' => $hideButton,
        'error' => "Does not work"
      ]);
    }
}
