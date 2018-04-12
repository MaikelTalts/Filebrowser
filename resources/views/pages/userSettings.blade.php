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
            <input type="text" class="form-control userModal" id="userName" value="{{$user->name}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="userEmail">Email:</label>
            <input type="email" class="form-control userModal" id="userEmail" value="{{$user->email}}">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="usr" id="passwordConfirmation1">Password:</label>
            <input type="password" class="form-control userModal" id="newPassword1" placeholder="Type new password">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="userEmail" id="passwordConfirmation2">Confirm password</label>
            <input type="password" class="form-control userModal" id="newPassword2" placeholder="Type new password">
          </div>
        </div>
      </div>
              <center>
                <button type="button" class="btn btn-primary updateUserInfo" role="button">Update</button>
              </center>
      </div>
    </div>
  </div>
