@extends('layouts.app')                                                                                             <!-- Define that this page extend layouts/app.blade.php -->
@section('content')                                                                                                 <!-- Define section named [Content] witch is included in app.blade.php page -->


<div class="container">                                                                                             <!-- Tabs for different setting tabs -->
    <h3>Select User</h3>
    <input id="searchByName" type="text" class="form-control" placeholder="Search by name">

    <ul class="list-group" id="userList">
        @foreach ($user as $key => $users)                                                                          <!-- List all users in database and their current privileges -->
          <li class='list-group-item file' id="userLi_{{$users->id}}"  style="border-radius:0px;">
            <span class="pull-left user userLink pseudolink" value="{{$users->id}}" id="userNameLink_{{$users->id}}">{{$users->name}}</span>
              @if ($users->user_privileges == 1)
                <span class="pull-right" id="userStatus_{{$users->id}}">User</span>
              @else
                <span class="pull-right" id="userStatus_{{$users->id}}"><strong>Admin</strong></span>
              @endif
            </select>
          </li>
        @endforeach
    </ul>
    <p style="display:none;"><?php echo $user ?> </p>
</div>

@endsection
