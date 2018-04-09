
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
$(document).on('change', '.folder_check', function() {
  var folderID = $(this).val();
  var userID = $('#userNameTitle').attr('value');
  updateFolderPrivileges(folderID, userID);
});

$(document).on('change', '.userStatusSelection', function(){
  var userID = $('#userNameTitle').attr('value');
  var statusSelection = $(this).val();
  updateUserStatus(userID, statusSelection);
});

$(document).on('click', '.deleteUser', function(){
  var userID = $('#userNameTitle').attr('value');
  //Confirm user deletion
  if (!confirm("Are you sure you wanna delete this user?") == true) {
  }
  else {
    deleteUser(userID);
  }
});

$('.btn-delete').on('click', function (e) {
  //Get user confirmation for file deletion
  if (!confirm("haluatko varmasti poistaa tämän tiedoston?")) {
    e.preventDefault();
  }
});

$('.btn-delete-folder').on('click', function (e) {
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
  $(this).siblings('.confirm').show(250);
  $(this).siblings('.cancel').show(250);
  $('.rename').hide(250);
  $('.download').hide(250);
  //Hide all the current notifications
  $("#notification_close-success").trigger("click");
  $("#notification_close-danger").trigger("click");
  showInputForRename($(this).siblings('.file_name_input'), $(this).siblings('.file_name'), $(this).siblings('.old_path'));
});

//After clicking confirm, hide both confirm and cancel buttons and bring rename buttons back to visible
$('body').on('click', '.confirm', function () {
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  switchBackToSpan($(this).siblings('.file_name'), $(this).siblings('.file_name_input'), $(this).siblings('.old_path'));
});

//After clicking cancel, hide both confirm and cancel buttons and bring rename buttons back to visible
$('.cancel').on('click', function () {
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  returnOldName($(this).siblings('.file_name'), $(this).siblings('.file_name_input'), $(this).siblings('.old_path'));
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

//Check if user changes dropdown value, pick the selected value and start userDirectoryPrivileges function with it
$(".user_dropdown").change(function () {
  var userID = $('.user_dropdown').val();
  userDirectoryPrivileges(userID);
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
  var userName = $('#userName').val();
  var userEmail = $('#userEmail').val();
  //Checks if the received email is in correct form.
  var correctEmail = isEmail(userEmail);
  if(correctEmail == true){
    updateUserInfo(userID, userName, userEmail);
  }
  else{
    var notificationMsg = "Check the email"
    showNotification(notificationMsg, "#CC0000");
  }
});

// == == == == == == == == == == FUNKTIOT  == == == == == == == == == == == //

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
  //Tuodaan input näkyville, tiedoston aikasiemmalla nimellä
  Old_name = oldPath.text(); //Noudetaan vanha nimi
  adress = document.getElementById('adress').innerHTML;
  $(input).show();
  $(input).val(span.text());
  $(span).hide();
}

function returnOldName(span, input, oldPath) {
  //Jos käyttäjä valitsee [Cancel], tuodaan vanha <span> teksti takaisin. (Vastaanotetaan span ja input elementit)
  $(input).hide(); //Piilotetaan input kenttä näkyvistä
  $(span).text(span.text()); //Muutetaan span elementin tekstiksi tiedoston vanha nimi
  $(span).show(); //Tuodaan span elementti näkyville
}

// == == == == == == == == == == AJAX  == == == == == == == == == == == //

//This function updates the current user in open modal.
function updateUserInfo(userID, userName, userEmail){
  $.ajax({
    method:'POST',
    url: '/update-user-info',
    data: {userID:userID, userName:userName, userEmail:userEmail, _token:token},
    success: function succes(response){
      if(!response.changeFailed){
        var userNameLink = "#userNameLink_" + userID;
        var notificationMsg = "User information updated";
        $(userNameLink).html(response.newName);
        showNotification(notificationMsg, "#2BBBAD");
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
      $('#userControlModal').html(response.success);
      $('#userControlModal').modal('toggle');
    },
    error: function error(){
      console.log("Ei toimi");
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


function switchBackToSpan(span, $input, oldPath) {
// Run namechange in server, if it success it also changes the name in front page as well. If namechange fails it returns the original name.
  $.ajax({
    method: 'POST',
    url: urlRename,
    data: { OldName: oldPath.text(), NewName: adress + "/" + $input.val(), _token: token },
    success: function success(response) {
      // Show preloader before changing the name on page
      $("#rename_notification_success").fadeIn("fast");
      $('#loader1').show("fast").delay(2000).hide("fast", function () {
        //Show preloader before change
        $('#upload_message').show().delay(1000);
        $($input).hide();
        $(span).text(response['new_name']);
        $(oldPath).text(response['new_path']);
        $(span).show();
      });
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
      $(userLi).fadeOut(700, function () {//Poistetaan käyttäjän rivi näkyvistä, jos poisto onnistui.
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
  var path = $('#adress').html();
  $.ajax({
    method: 'POST',
    url: urlcreateDirectory,
    data: { dir_name: value, creation_dir: path, _token: token },
    success: function success(response) {

      console.log(response.success); //Jos kansion luonti onnistuu, luodaan kansiorivi, johon sijoitetaan käyttäjän kirjoittama kansion nimi, sekä poisto painike.
      console.log(response.append);
      $('.directories').append(response.append);
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

//This function updates selected users (in settings modal), privilege to selected folder
function userDirectoryPrivileges(userID) {
  $.ajax({
    method: 'POST',
    url: '/user-directory-privileges',
    data: { userId: userID, _token: token },
    success: function success(response) {
      $('.directorylist').show(100, function () {
        $('.directorylist').html(response.success);
      });
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

// TULEE KORJATA - siten että tiedostopolku yritetään noutaa ainoastaan silloin kun käyttäjä on juuressa tai show ikkunassa  //
function breadcrumbs() {
  var current_path = document.getElementById('adress').innerHTML; // Noudetaan app.blade.php sivulta kansiopolku
  var folder_structure = current_path.split("/"); // Erotellaan noudetun kansiopolun kansiot
  var count = folder_structure.length; // Tarkistetaan eroteltujen kansioiden määrä
  var folder_name = ""; // Luodaan globaali muuttuja, jota käytetään tieostopolun tulostamiseen
  var path = ""; // Luodaan globaali muuttuja, johon sijoitetaan kaikki kansiopolun kansiot yksitellen.

  for (i = 0; i < count; i++) {
    // Suoritetaan for loop (Niin monesti, kuin on kansiopolussa kansioita)
    path += folder_structure[i] + "/"; // Lisätään jokaisella kierroksella polkuun seuraava kansiopolun kansio
    folder_name = folder_structure[i]; // Muutetaan jokaisella kierroksella tulostettavan kansion nimi indeksin osoittamaa kansiota
    $('.breadcrumb').append($("<a></a>", { // Luodaan jokaisella kierroksella uusi linkkinä toimiva kansio
      'class': 'breadcrumb-item',
      text: folder_name,
      href: "http://localhost:8000/" + path
    }));
    $('.breadcrumb').append($("<span>", {
      text: " / "
    }));
  }
}
breadcrumbs();
