
<div class="col-md-6" style="padding:20px;">
    <h5>Upload Access</h5>
    <div class="form-group">
      <select class="form-control" style="width:100%;" @if($user == 1) disabled @endif>
        <option @if($selectedUser->user_upload_privilege == 2) selected @endif>Allowed</option>
        <option @if($selectedUser->user_upload_privilege == 1) selected @endif>Not allowed</option>
      </select>
    </div>
</div>

<div class="col-md-6" style="padding:20px;">
  <h5>Directory Access</h5>
      <ul class="list-group" style="margin:0px;">
        @foreach($directories as $directory)
          <?php
          if(in_array($directory->id, $data)){
            $check = true;
          }
          else{
            $check = false;
          }

          ?>
          <li class="list-group-item">
            <span>{{$directory->folder_name}}</span>
            @if($check == true)
            <input type="checkbox" value="{{$directory->id}}" class="pull-right folder_check" style="height:20px; width:20px;" checked @if($user==1) disabled @endif>
            @else
            <input type="checkbox" value="{{$directory->id}}" class="pull-right folder_check" style="height:20px; width:20px;" @if($user==1) disabled @endif>
            @endif
          </li>
        @endforeach
      </ul>
</div>
