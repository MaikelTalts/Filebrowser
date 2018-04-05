@extends('layouts.app')                                                                                             <!-- Define that this page extend layouts/app.blade.php -->
@section('content')                                                                                                 <!-- Define section named [Content] witch is included in app.blade.php page -->


<div class="container">                                                                                             <!-- Tabs for different setting tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#users">User status</a></li>
    <li><a data-toggle="tab" href="#folderPrivileges">Privileges</a></li>
    <li><a data-toggle="tab" href="#filePrivileges">Files</a></li>
  </ul>

  <div class="tab-content">

    <div id="users" class="tab-pane fade in active">
        <h3>User Status</h3>
        <input id="searchByName" type="text" class="form-control" placeholder="Search by name">

        <ul class="list-group" id="userList">
            @foreach ($user as $key => $users)                                                                      <!-- List all users in database and their current privileges -->
              <li class='list-group-item file'>
                <span class="pull-left user userLink pseudolink" value="{{$users->id}}">{{$users->name}}</span>
                  @if ($users->user_privileges == 1)
                    <span class="pull-right">User</span>
                  @else
                    <span class="pull-right"><strong>Admin</strong></span>
                  @endif
                </select>
                <p class="glyphicon glyphicon-ok pull-right privileges_success" aria-hidden="true"></p>
                <p class="glyphicon glyphicon-remove pull-right privileges_error" aria-hidden="true"></p>
              </li>
            @endforeach
        </ul>
    </div>

    <div id="folderPrivileges" class="tab-pane fade">                                                               <!-- Folder privileges tab -->
        <h3>Privileges</h3>
        <div class="col-md-12" style="margin:0px; padding:0px;">
            <div class="col-md-6" style="padding:20px;">
                <h5>Select User</h5>
                <select class="form-control select user_dropdown" id="creationDirectory" style="width:100%;">     <!-- Select user dropdown, that contains a list of all users in users table -->
                    <option value="" hidden>Please select</option>
                    @foreach($user as $key => $us_er)                                                             <!-- Foreach user in user table create selectable option for select input -->
                      <option value="{{$us_er->id}}">{{$us_er->name}}</option>
                    @endforeach
                </select>
          </div>
      </div>
        <div class=" directorylist">                                                                              <!-- After selecting user, content will be created and printed inside this div element by ajax function -->
        </div>

  </div>

    <div id="filePrivileges" class="tab-pane fade">
      <h3>Files</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
</div>
    <p style="display:none;"><?php echo $user ?> </p>
  </div>
@endsection
