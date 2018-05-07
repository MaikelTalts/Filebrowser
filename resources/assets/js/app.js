
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.


Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
*/
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// == == == == == == == == == GLOBAL VARIABLES == == == == == == == ==  //
// Global variables [Important!]
Old_name = "";
adress = "";

// == == == == == == == == == == BUTTON CLICK == == == == == == == == == == == //
//When user clicks folder checkbox in settings modal, it starts updateFolderPrivileges function
$(document).on('change', '.folder_check', function() {
  var folderID = $(this).val();
  var userID = $('#userNameTitle').attr('value');
  updateFolderPrivileges(folderID, userID);
});

//In settings page, when user status is changed, it starts updateUserStatus function
$(document).on('change', '.userStatusSelection', function(){
  var userID = $('#userNameTitle').attr('value');
  var statusSelection = $(this).val();
  updateUserStatus(userID, statusSelection);
});

//By clicking delete user button in settings page and user modal, browser confirms the deletion and after that the deleteUser function will be called
$(document).on('click', '.deleteUser', function(){
  var userID = $('#userNameTitle').attr('value');
  //Confirm user deletion
  if (!confirm("Are you sure you wanna delete this user?") == true) {
  }
  else {
    deleteUser(userID);
  }
});

//By clicking btn-delete class button, the selected file will be deleted from system.
$(document).on('click', '.btn-delete', function(e){
  //Get user confirmation for file deletion
  if (!confirm("haluatko varmasti poistaa tämän tiedoston?")) {
    e.preventDefault();
  }
});

//By clicking the btn-delete-folder class button, the selected folder will be deleted from the system 
$(document).on('click', '.btn-delete-folder', function(e){
  //Get user confirmation for folder deletion
  if (!confirm("Haluatko varmasti poistaa tämän kansion?")) {
    e.preventDefault();
  }
});

$('.btn-create-directory').on('click', function () {
  createDirectory($("#directoryName").val());
});

// When user clicks any rename class button, hide all rename buttons and bring the confirm and cancel buttons on the same row visible. Start createInputForRename function.
$('body').on('click', '.rename', function () {
  //Get the path for fileNameInput
  var filePath = $(this).parent('.itemButtons').attr('data-filename');
  var itemSpans = $('.itemSpans[data-filename="'+filePath+'"]');
  var fileNameInput = $(itemSpans).children('.fileNameInput');
  var fileName = $(itemSpans).children('.fileName');
  var oldPath = $(itemSpans).children('.oldFilePath');
  //Show confirm and cancel buttons and hide rename and download buttons (too many buttons!!)
  $(this).siblings('.confirm').show(250);
  $(this).siblings('.cancel').show(250);
  $('.rename').hide(250);
  $('.download').hide(250);
  //Hide all the current notifications
  $("#notification_close-success").trigger("click");
  $("#notification_close-danger").trigger("click");

  showInputForRename(fileNameInput, fileName, oldPath);
});

//After clicking confirm, hide both confirm and cancel buttons and bring rename buttons back to visible
$('body').on('click', '.confirm', function () {
  var filePath = $(this).parent('.itemButtons').attr('data-filename');
  var itemSpans = $('.itemSpans[data-filename="'+filePath+'"]');
  var fileName = $(itemSpans).children('.fileName');
  var fileNameInput = $(itemSpans).children('.fileNameInput');
  var oldPath = $(itemSpans).children('.oldFilePath');
  var downloadPath = $(this).siblings('.download');
  var deletePath = $(this).siblings('.btn-delete');
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  switchBackToSpan(fileName, fileNameInput, oldPath, downloadPath, deletePath);
});

//After clicking cancel, hide both confirm and cancel buttons and bring rename buttons back to visible
$(document).on('click', '.cancel', function(){
  var filePath = $(this).parent('.itemButtons').attr('data-filename');
  var itemSpans = $('.itemSpans[data-filename="'+filePath+'"]');
  var fileName = $(itemSpans).children('.fileName');
  var fileNameInput = $(itemSpans).children('.fileNameInput');
  var oldPath = $(itemSpans).children('.oldFilePath');
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  returnOldName(fileName, fileNameInput, oldPath);
});
//After clicking the x in both success and error notifications it closes the notification with slow fadeout.
$('#notification_close-success').click(function () {
  $("#rename_notification_success").fadeOut("slow", function () {
    $('#upload_message').hide();
  });
});

$('#notification_close-danger').click(function () {
  $("#rename_notification_danger").fadeOut("slow", function () {});
});

//Check if user changes users upload privilege, if so check witch user the current user did select and start updateUploadPrivileges function with it.
$(document).on('change', '.userUploadSelection', function(){
  var userID = $('#userNameTitle').attr('value');
  var uploadSelection = $('.userUploadSelection').val();
  updateUploadPrivileges(userID, uploadSelection);
});

//When current system user clicks any other user name in settings page, pick up that specific users ID and start printUserPage function with that ID
$(document).on('click', '.userLink', function(){
  //Pick users ID
  var userID = $(this).attr('value');
  //Start function with picked ID
  printUserPage(userID);
});

/*This jquery line watches if current user is making changes in settings page on users. If the user clicks the updateUserInfo button, it starts
  updateUserInfo function */
$(document).on('click', '.updateUserInfo', function(){
  var userID = $('#userNameTitle').attr('value');
  var oldUserName = $('#userName').attr("value");
  var userNameInput = $('#userName').val();
  var userEmail = $('#userEmail').val();
  //Checks if the received email is in correct form.
  var correctEmail = isEmail(userEmail);
  //Check if both password inputs contains the same value
  var correctPassword = checkIfSamePassword();
  if(correctEmail == true){
    updateUserInfo(userID, oldUserName, userNameInput, userEmail);
  }
  else{
    var notificationMsg = "Check the email"
    showNotification(notificationMsg, "#CC0000");
  }
  if(correctPassword[0] == true){
    updateUserPassword(userID, correctPassword[1]);
  }
});


$(document).on('click', '#userSettings', function(){
  showUserSettings();
});

$(document).on('keyup', '#newPassword1', function(){
  checkIfSamePassword();
});

$(document).on('keyup', '#newPassword2', function(){
  checkIfSamePassword();
});

$(document).on('click', '#loadMoreActivities', function(){
  var amount = $(this).attr('value');
  $(this).val(parseInt(amount) + 10);
  loadMoreActivities(amount);
});

// == == == == == == == == == == FUNKTIOT  == == == == == == == == == == == //

function checkIfSamePassword(){
  //Get both password input values and compare them.
  var input1Value = $('#newPassword1').val();
  var input2Value = $('#newPassword2').val();
  var correctPassword = [];
  //If both are empty display both input headliners as black
  if(input1Value == "" || input2Value == ""){
    $('#passwordConfirmation1').css('color', 'black');
    $('#passwordConfirmation2').css('color', 'black');
    correctPassword[0] = false;
  }
  //If both have the same exact same text display both input headliners as green
  else if(input1Value == input2Value){
    $('#passwordConfirmation1').css('color', '#2BBBAD');
    $('#passwordConfirmation2').css('color', '#2BBBAD');
    correctPassword[0] = true;
    correctPassword[1] = input1Value;

  }
  //If both inputs contain text, but not the same text display both input headliners as black
  else{
    $('#passwordConfirmation1').css('color', 'black');
    $('#passwordConfirmation2').css('color', 'black');
    correctPassword[0] = false;
  }
  return correctPassword;
}

/*This function shows up the notificationBar from layouts/modal.blade.php. It requires message and background color that depends on if the user action
  is successful or not. */
function showNotification(message, background){
  var x = document.getElementById("notificationBar");
  x.innerHTML = message;
  $(x).css("background-color", background);
  x.className = "show";
  setTimeout(function(){x.className = x.className.replace("show", "");}, 3000);
}

//This function is called when user clicks on .updateUserInfo class button, it checks if received email is in correct form
function isEmail(email){
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$('#searchByName').keyup(function(){
  //Declare variables
  var input = document.getElementById('searchByName');
  var filter = input.value.toUpperCase();
  var ul = document.getElementById('userList');
  var li = ul.getElementsByTagName('li');
  //Run loop as many time as there is rows in table
  for (i = 0; i < li.length; i++){
  var user = li[i].getElementsByClassName("user")[0];
    //If the input field text exists in table row it will be displayed
    if(user.innerHTML.toUpperCase().indexOf(filter) >-1){
      li[i].style.display = "";
    }
    //If it does not exist it will get display:none style
    else{
      li[i].style.display = "none";
    }
  }
});

function showInputForRename(input, span, oldPath) {
  //Bring input back to visible with old filename
  //Get the old filepath
  Old_name = oldPath.text();
  adress = $('#currentPath').attr('value') + "/";
  //Get the current file name
  var currentName = span.text();
  //Split the name to get the filetype
  var nameSplit = currentName.split(".");
  //Check the array length and decrease with one
  var splitLength = nameSplit.length -1;
  //Get the last element in array and add . at the start to create filetype
  var fileType = "." + nameSplit[splitLength];
  //Add the filetype in to the oldPath element as value
  $(oldPath).attr('value', fileType);
  //Remove the path from the current name to get the actual name inside input
  var name = currentName.replace(fileType, "");
  $(input).show();
  $(input).val(name);
  $(span).hide();
}

function returnOldName(span, input, oldPath) {
  //If user selects [Cancel], bring back the old <span> text back.
  $(input).hide();
  $(span).text(span.text());
  $(span).show();
}

// == == == == == == == == == == AJAX  == == == == == == == == == == == //

//This ajax function wille be called when user cliks "Load more" button in activity feed.
function loadMoreActivities(amount){
  $.ajax({
    method: 'POST',
    url: '/load-more-activities',
    data: {amount:amount, _token:token},
    success: function success(response){
      //If the called function succeeds insert the received json data into tablebody

      $('#activityLoader').show().delay(1000).hide(0, function () {
        $('#activityTable').html(response.success);
        if(response.hideButton == true){
          $('#loadMoreActivities').css('display', 'none');
          $('#noActivities').css('display', 'block');
        }
      });

    },
    error: function success(response){
      console.log(response.error)
    }
  })
}

//updateUserPassword will be ran when user or admin changes users password.
function updateUserPassword(userID, correctPassword){
$.ajax({
  method: 'POST',
  url: '/update-user-password',
  data: {userID:userID, password:correctPassword, _token:token},
  success: function success(response){
  },
  error: function error(response){
    console.log(response.error);
  }
})
}

//ShowUserSettings is used when user with user_privileges as 1 opens settings page. Page will be generated and printed into userControlModal.
function showUserSettings(){
  $.ajax({
    method: 'POST',
    url: 'show-user-settings',
    data: {_token:token},
    success: function success(response){
      $('#userControlModal').html(response.success);
      $('#userControlModal').modal('toggle');
    },
    error: function error(response){

    }
  });
}

//This function updates the current user in open modal.
function updateUserInfo(userID, oldUserName, userNameInput, userEmail){
  $.ajax({
    method:'POST',
    url: '/update-user-info',
    data: {userID:userID, oldUserName:oldUserName, userNameInput:userNameInput ,userEmail:userEmail, _token:token},
    success: function succes(response){
      if(!response.changeFailed){
        var userNameLink = "#userNameLink_" + userID;
        var notificationMsg = "User information updated";
        $(userNameLink).html(response.newName);
        showNotification(notificationMsg, "#2BBBAD");
        //If the currently edited user is same user that has logged in, update the name in navigation and modal as well.
        if(response.sameUser == true){
          $('#userNavigation').text(response.newName);
          $('#userNameTitle').text(response.newName);
        }
      }
      else{
        var notificationMsg = "Check the name";
        showNotification(notificationMsg, "#CC0000");
      }
    },
    error: function error(response){
      console.log(response.error);
    }
  });
}

//This function is used to get user information from database and to print it inside userControlModal element inside layouts/modal.blade.php
function printUserPage(userID){
  $.ajax({
    method:'POST',
    url: '/pring-user-page',
    data: {userID:userID, _token:token},
    success: function success(response){
      if(response.denied){
        showNotification(response.error, "#CC0000");
      }
      else{
      $('#userControlModal').html(response.success);
      $('#userControlModal').modal('toggle');
      }
    },
    error: function error(){
      console.log("Does not work");
    }
  })


}

//Function starts ajax call to update selected users upload privileges
function updateUploadPrivileges(userID, uploadSelection){
  $.ajax({
    method: 'POST',
    url: '/update-upload-privileges',
    data: { userID: userID, uploadSelection: uploadSelection, _token: token },
    success: function success(response) {
      showNotification(response.notificationMsg, "#2BBBAD");
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

//Function starts ajax call to update selected users rights to clicked folder
function updateFolderPrivileges(folderID, userID){
  $.ajax({
    method: 'POST',
    url: '/update-user-folder-privileges',
    data: { userID: userID, folderID: folderID, _token: token },
    success: function success(response) {
      showNotification(response.notificationMsg, "#2BBBAD");
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}


function switchBackToSpan(span, $input, oldPath, downloadPath, deletePath) {
  var fileType = $(oldPath).attr('value');
  oldPathName = oldPath.text();
// Run namechange in server, if it success it also changes the name in front page as well. If namechange fails it returns the original name.
  $.ajax({
    method: 'POST',
    url: urlRename,
    data: { OldName: oldPath.text(), NewName: adress + $input.val() + fileType , _token: token },
    success: function success(response) {
      // Show preloader before changing the name on page
      $("#rename_notification_success").fadeIn("fast");
      $('#loader1').show("fast").delay(2000).hide("fast", function () {
        //Show preloader before change
        $('#upload_message').show().delay(1000);
        $($input).hide();
        $(downloadPath).attr('href', "/download"+response.new_path);
        $(deletePath).attr('href', "/delete"+response.new_path);
        $(span).text(response['new_name']);
        $(oldPath).text(response['new_path']);
        $(span).show();
      });
      //$('.btn-delete[data-filename='+  data.OldName +']').attr('data-filename', data.NewName)
    },
    error: function error(response) {
      //If namechange does not success then return the old name back
      returnOldName(span, $input, oldPath);
      $("#rename_notification_danger").fadeIn("slow");
    }
  });
}

function updateUserStatus(userID, statusSelection) {
  //This function runs ajax to change selected users status.
  $.ajax({
    method: 'POST',
    url: urlPrivilege,
    data: { statusSelection: statusSelection, userID: userID, _token: token },
    success: function success(response) {
      var userStatusSpan = '#userStatus_' + userID;
      $(userStatusSpan).html(response.newUserStatus);
      showNotification(response.notificationMessage, "#2BBBAD");
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

//This function runs ajax to delete selected user. It also requires confirmation.
function deleteUser(userID) {
  $.ajax({
    method: 'POST',
    url: urlDeleteUser,
    data: { userID: userID, _token: token },
    success: function success(response) {
      var userLi = "#userLi_"+userID;
      $('#userControlModal').modal('toggle');
      $(userLi).fadeOut(700, function () {
        //Hide user row if the deletion succeeds
        showNotification(response.notificationMessage, "#2BBBAD");
      });

    },
    error: function error(response) {
      var notificationError = "Cannot delete this user";
      showNotification(response.notificationMessage, "#2BBBAD");
    }
  });
}

//This function creates directory with ajax call.
function createDirectory(value) {
  //Luodaan kansio ajax kutsulla.
  var path = $('#currentPath').attr('value');
  $.ajax({
    method: 'POST',
    url: urlcreateDirectory,
    data: { dir_name: value, creation_dir: path, _token: token },
    success: function success(response) {
       //If directory creation succeeds, receive a <li> element of that folder and append it to folder list.
      $('.directories').append(response.append);
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}
