@extends('layouts.app')                                                                                             <!-- Define that this page extend layouts/app.blade.php -->
@section('content')                                                                                                 <!-- Define section named [Content] witch is included in app.blade.php page -->


<div class="container">                                                                                             <!-- Tabs for different setting tabs -->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:#343d46; color:white;">Overview</div>
          <div class="panel-body text-center">
            <div class="row">
              <div class="col-xs-4 outerAnalyticsBox">
                <div class="col-sm-12 innerAnalyticsBox" >
                <span class="analyticIcon"><i class="far fa-user"></i></span>
                <br>
                <span>{{$userAmount}}</span>
                <br>
                <span>Users</span>
              </div>
              </div>
              <div class="col-xs-4 outerAnalyticsBox">
                <div class="col-sm-12 innerAnalyticsBox" >
                <span class="analyticIcon"><i class="far fa-file"></i></span>
                <br>
                <span>{{$files}}</span>
                <br>
                <span>Files</span>
              </div>
              </div>
              <div class="col-xs-4 outerAnalyticsBox">
                <div class="col-sm-12 innerAnalyticsBox">
                <span class="analyticIcon"><i class="far fa-folder-open"></i></span>
                <br>
                <span>{{$directories}}</span>
                <br>
                <span>Directories</span>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:#343d46; color:white;">Select User</div>
            <div class="panel-body">
              <input id="searchByName" type="text" class="form-control" placeholder="Search by name">

              <ul class="list-group" id="userList">
                  @foreach ($users as $user)                                                                          <!-- List all users in database and their current privileges -->
                    <li class='list-group-item file' id="userLi_{{$user->id}}">
                      <span class="pull-left user userLink pseudolink" value="{{$user->id}}" id="userNameLink_{{$user->id}}">{{$user->name}}</span>
                        @if ($user->user_privileges == 1)
                          <span class="pull-right" id="userStatus_{{$user->id}}">User</span>
                        @else
                          <span class="pull-right" id="userStatus_{{$user->id}}"><strong>Admin</strong></span>
                        @endif
                      </select>
                    </li>
                  @endforeach
              </ul>
          </div>
        </div>
      </div>
    </div>
</div>

    <p style="display:none;"><?php echo $user ?> </p>
</div>

@endsection
