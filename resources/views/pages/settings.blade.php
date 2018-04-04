@extends('layouts.app')

@section('content')

<div class="container">                                                         <!-- Välilehdet eri asetuksille -->
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#users">Users</a></li>
    <li><a data-toggle="tab" href="#folderPrivileges">Privileges</a></li>
    <li><a data-toggle="tab" href="#filePrivileges">Files</a></li>
  </ul>

  <div class="tab-content">

    <div id="users" class="tab-pane fade in active">
        <h3>User rights</h3>                                                    <!-- Admin asetukset -->
        <input type="text" class="form-control" placeholder="f002 Etsi nimellä..." style="width:120px; margin-top:10px; margin-bottom:10px;">

        <ul class="list-group">
            @foreach ($user as $key => $users)                                  <!-- Listataan kaikki tietokannassa olevat käyttäjät ja niiden tämänhekiset oikeudet -->
              <li class='list-group-item file'>
                <span class="pull-left user">{{$users->name}}</span>
                <span style="display:none;" class="userId">{{$users->id}}</span>
                @if($users->name == "admin")
                  <button type="button" class="btn btn-danger pull-right disabled" role="button">Delete</button>
                  <button type="button" class="btn btn-primary pull-right disabled" role="button">Update</button>
                @else
                  <button type="button" class="btn btn-danger pull-right delete-user" role="button">Delete</button>
                  <button type="button" class="btn btn-primary pull-right privileges-1" role="button">Update</button>
                @endif
                <select class="form-control pull-right select" <?php if($users->name == "admin"){echo 'disabled';}?>>
                    <option <?php if($users->user_privileges == 1){echo 'selected';}?> value="1">User</option>
                    <option <?php if($users->user_privileges == 2){echo 'selected';}?> value="2">Admin</option>
                </select>
                <p class="glyphicon glyphicon-ok pull-right privileges_success" aria-hidden="true"></p>
                <p class="glyphicon glyphicon-remove pull-right privileges_error" aria-hidden="true"></p>
              </li>
            @endforeach
        </ul>
    </div>

    <div id="folderPrivileges" class="tab-pane fade">
        <h3>Privileges</h3>
        <div class="col-md-12" style="margin:0px; padding:0px;">
            <div class="col-md-6" style="padding:20px;">
                <h5>Select User</h5>
                <select class="form-control select user_dropdown" id="creationDirectory" style="width:100%;">
                    <option value="" hidden>Please select</option>
                    @foreach($user as $key => $us_er)
                      <option value="{{$us_er->id}}">{{$us_er->name}}</option>
                    @endforeach
                </select>
          </div>
      </div>
        <div class=" directorylist">
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
