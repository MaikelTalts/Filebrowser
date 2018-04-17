
<div class="container text-center">
  <!-- If current event was successful the session will get 'success', including the message that needs to be shown -->
@if(session('success'))
  <div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{session('success')}} </strong>
  </div>
@endif

<!-- If current event was unsuccesscul the session will get 'error' including the message that needs to be shown -->
@if(session('error'))
  <div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{session('error')}}</strong>
  </div>
@endif

<!-- If the deletion event was successfull the session will get 'success' including the message that needs to be shown -->
@if(session('delete'))
  <div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{session('delete')}}</strong>
  </div>
@endif
</div>

<!-- Alert for successful file renaming -->
<div class="alert alert-success alert-dismissable fade in rename-notification text-center" id="rename_notification_success">
    <span class="close" id="notification_close-success" aria-label="close">&times;</span>
    <center><div class="loader" id="loader1"></div></center>
    <strong id="upload_message">Rename completed</strong>
</div>

<!-- Alert for unsuccessful rename event -->
<div class="alert alert-danger alert-dismissable fade in rename-notification text-center" id="rename_notification_danger">
    <span class="close" id="notification_close-danger" aria-label="close">&times;</span>
    <strong>Filename was not changed</strong>
</div>
