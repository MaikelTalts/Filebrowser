<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center>  <h4 class="modal-title" id="userNameTitle" value="{{$user->id}}">{{$user->name}}</h4> </center>
    </div>
    <div class="modal-body">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" class="form-control" id="userName" style="width:100%;" value="{{$user->name}}" @if($user->id == 1) disabled @endif>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="userEmail">Email:</label>
            <input type="email" class="form-control" id="userEmail" style="width:100%;" value="{{$user->email}}" @if($user->id == 1) disabled @endif>
          </div>
        </div>
      </div>

      <div class="row"  style="margin-top:10px;">
        <div class="col-md-6">
          <div class="form-group">
           <label for="sel1">User status</label>
           <select class="form-control userStatusSelection" id="sel1" style="width:100%;" @if($user->id == 1) disabled @endif>
             @if ($user->user_privileges == 1)
              <option value="2">Admin</option>
              <option selected value="1">User</option>
             @else
             <option value="1">User</option>
             <option selected value="2">Admin</option>
             @endif
           </select>
          </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
             <label for="sel1">Upload rights</label>
             <select class="form-control userUploadSelection" id="sel1" style="width:100%;" @if($user->id == 1) disabled @endif>
               @if ($user->user_upload_privilege == 1)
                 <option selected value="1">Denied</option>
                 <option value="2">Allowed</option>
               @else
                 <option value="1">Denied</option>
                 <option selected value="2">Allowed</option>
               @endif
             </select>
            </div>
          </div>
        </div>

        <div class="row"  style="margin-top:20px;">
          <div class="col-md-12">
            <div class="panel-group" id="accordion">
              <div class="panel panel-primary" >
                <div class="panel-heading text-center" >
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="text-decoration:none;">Directory privileges</a>
                  </h4>
                </div>
                  <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body" style="padding:0px;">
                      <table class="userControlTable">
                        <tr class="header">
                          <th style="width:90%; display:none;">a</th>
                          <th style="width:10%; display:none">a</th>
                        </tr>
                        @foreach($directories as $directory)
                          <?php
                          if(in_array($directory->id, $dirArray)){
                            $check = true;
                          }
                          else{
                            $check = false;
                          }
                          ?>
                          <tr>
                            <td><span>{{$directory->folder_name}}</span></td>
                            <td>
                            @if($check == true)
                              <input type="checkbox" value="{{$directory->id}}" class="pull-right folder_check" style="height:20px; width:20px;" checked @if($user->id==1) disabled @endif>
                            @else
                              <input type="checkbox" value="{{$directory->id}}" class="pull-right folder_check" style="height:20px; width:20px;" @if($user->id==1) disabled @endif>
                            @endif
                          </td>
                          </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            @if($user->id != 1)
              <center>
                <button type="button" class="btn btn-primary updateUserInfo" role="button">Update</button>
                <button type="button" class="btn btn-danger deleteUser" role="button">Delete</button>
              </center>
            @endif
      </div>
    </div>
  </div>
