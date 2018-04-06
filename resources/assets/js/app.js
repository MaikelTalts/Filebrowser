
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

// == == == == == == == == == GLOBAALIT MUUTTUJAT == == == == == == == ==  //
Old_name = ""; // Globaalit muuttujat [Vanha nimi], sekä tiedoston polku, joka poistetaan tiedostoa uudelleen nimettäessä.
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

$('.privileges-1').on('click', function () {
  //Käyttäjän klikatessa update painiketta, saman rivin valinta, muutettavan ID sekä success ja error kuvakkeet lähetetään funktiolle sitä kutsuttaessa.
  //updateUserStatus($(this).siblings('.select'), $(this).siblings('.userId'), $(this).siblings('.privileges_success'), $(this).siblings('.privileges_error'));
});

$('.select').on('click', function () {
  //Käyttäjän klikatessa mitä tahansa select dropdownia kaikki tähänastiset success ja error kuvakkeet poistetaan näkyvistä
  $('.privileges_success').fadeOut(700, function () {
    // Animation complete.
  });
  $('.privileges_error').fadeOut(700, function () {
    // Animation complete.
  });
});

$(document).on('click', '.deleteUser', function(){
  var userID = $('#userNameTitle').attr('value');
  //Varmistetaan käyttäjän poisto
  if (!confirm("Are you sure you wanna delete this user?") == true) {
    console.log("Painoit ei");
  } else {
    deleteUser(userID);
    console.log("Painoit kyllä");
  }
});

$('.btn-delete').on('click', function (e) {
  //Haetaan käyttäjältä varmistus tiedoston poistoon.
  if (!confirm("haluatko varmasti poistaa tämän tiedoston?")) {
    e.preventDefault();
  }
});

$('.btn-delete-folder').on('click', function (e) {
  //Haetaan käyttäjältä varmistus tiedostojen poistoon.
  if (!confirm("Haluatko varmasti poistaa tämän kansion?")) {
    e.preventDefault();
  }
});

$('.btn-create-directory').on('click', function () {
  createDirectory($("#directoryName").val());
});
/* Käyttäjän klikatessa mitä tahansa rename classin painiketta, kaikki saman sivun rename painikkeet poistetaan näkyvistä,
confirm & cancel painikkeet tuodaan näkyville ja käynnistetään createInputForRename funktio.*/
$('body').on('click', '.rename', function () {
  $(this).siblings('.confirm').show(250);
  $(this).siblings('.cancel').show(250);
  $('.rename').hide(250);
  $('.download').hide(250);
  $("#notification_close-success").trigger("click"); // Käytetään notificationin-success piilottamiseen samaa toimintoa kuin myöhemmin luodun painikkeen funktiossa.
  $("#notification_close-danger").trigger("click"); // Käytetään notification-danger piilottamiseen samaa toimintoa kuin myöhemmin luodun painikkeen funktiossa.
  showInputForRename($(this).siblings('.file_name_input'), $(this).siblings('.file_name'), $(this).siblings('.old_path'));
});
/* Käyttäjän klikatessa confirm painiketta cancel ja confirm painikkeet piilotetaan näkyvistä,
rename painikkeet tuodaan näkyville, ja käynnistetään switchBackToSpan funktio.*/
$('body').on('click', '.confirm', function () {
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  switchBackToSpan($(this).siblings('.file_name'), $(this).siblings('.file_name_input'), $(this).siblings('.old_path'));
});
/* Käyttäjän klikatessa cancel painiketta, cancel ja confirm painikkeet piilotetaan näkyvistä,
rename painikkeet tuodaan näkyville, ja käynnistetään returnOldName funktio.*/
$('.cancel').on('click', function () {
  $('.cancel').hide(250);
  $('.confirm').hide(250);
  $('.rename').show(250);
  $('.download').show(250);
  returnOldName($(this).siblings('.file_name'), $(this).siblings('.file_name_input'), $(this).siblings('.old_path'));
});

/*Käyttäjän klikatessa notification_success tai notification_dangerissa sijaitsevaa raksia painiketta. Ilmoitus piilotetaan hitaasti himmentämällä,
nämä molemmat triggeröidään myös käyttäjän klikatessa mitä tahansa rename luokan painiketta. */
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

$(document).on('click', '.updateUserInfo', function(){
  var userID = $('#userNameTitle').attr('value');
  var userName = $('#userName').val();
  var userEmail = $('#userEmail').val();
  var correctEmail = isEmail(userEmail);
  if(correctEmail == true){
    updateUserInfo(userID, userName, userEmail);
  }
  else{

  }

});

// == == == == == == == == == == FUNKTIOT  == == == == == == == == == == == //

function showNotificationBar(message){
  var x = document.getElementById("notificationBar");
  x.innerHTML = message;
  x.className = "show";
  setTimeout(function(){x.className = x.className.replace("show", "");}, 3000);
}

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

function updateUserInfo(userID, userName, userEmail){
  $.ajax({
    method:'POST',
    url: '/update-user-info',
    data: {userID:userID, userName:userName, userEmail:userEmail, _token:token},
    success: function succes(response){
      if(!response.changeFailed){
        var userNameLink = "#userNameLink_" + userID;
        $(userNameLink).html(response.newName);
        var notificationMsg = "User information updated";
        showNotificationBar(notificationMsg);
      }
    },
    error: function error(response){
      console.log(response.error);
    }
  });
}

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
      showNotificationBar(response.notificationMsg);
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
      showNotificationBar(response.notificationMsg);
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}


function switchBackToSpan(span, $input, oldPath) {

  //Suoritetaan nimenmuutos palvelimella. Onnistuessaan muuttaa nimen palvelimella ja sivulla. Epäonnistuessa palauttaa sivulle aikaisemman nimen, palvelimella ei muutosta.
  $.ajax({ //Ajax pyyntö joka lähettää mukanaan tiedoston vanhan nimen, uuden nimen, sekä istunnon CSRF tokenin
    method: 'POST',
    url: urlRename,
    data: { OldName: oldPath.text(), NewName: adress + "/" + $input.val(), _token: token },
    success: function success(response) {
      // Jos [FileController@rename palauttaa success]:in suoritetaan, nimen visuaalisella puolella nimenvaihto uuteen, ja näytetään preloade ennen nimen vaihtoa.
      $("#rename_notification_success").fadeIn("fast"); //Tuodaan preloader alert elementti nopeasti näkyville.
      $('#loader1').show("fast").delay(2000).hide("fast", function () {
        //Tuodaan preloader näkyville, joka pyörii 2sec, jonka jälkeen katoaa.
        $('#upload_message').show().delay(1000); //Nöytetän ilmoitus onnistuneesta nimenmuutoksesta.
        $($input).hide(); //Piilotetaan input kenttä
        $(span).text(response['new_name']); //Muutetaan span elementin teksti uudeksi vastaanotetuksi tekstiksi
        $(oldPath).text(response['new_path']);
        $(span).show(); //Tuodaan span elementti näkyville
      });
    },
    error: function error(response) {
      //Jos [FileController@rename palauttaa error] koodin, suoritetaan nimen palautus ennalleen
      returnOldName(span, $input, oldPath); //Kutsutaan returnOldName funktiota, lähetetään span ja input elementit mukana.
      $("#rename_notification_danger").fadeIn("slow"); //Jos nimenmuutos ei onnistunut tulostetaan virheilmoitus
    }
  });
}

function updateUserStatus(userID, statusSelection) {
  $.ajax({ //Suoritetaan käyttöoikeuksien muutos ajax kutsuna
    method: 'POST',
    url: urlPrivilege,
    data: { statusSelection: statusSelection, userID: userID, _token: token },
    success: function success(response) {
      var userStatusSpan = '#userStatus_' + userID;
      $(userStatusSpan).html(response.newUserStatus);
      showNotificationBar(response.notificationMessage);
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

function deleteUser(userID) {
  $.ajax({
    method: 'POST',
    url: urlDeleteUser,
    data: { userID: userID, _token: token },
    success: function success(response) {
      var userLi = "#userLi_"+userID;
      $(userLi).fadeOut(700, function () {//Poistetaan käyttäjän rivi näkyvistä, jos poisto onnistui.
        // Animation complete.
      });
      console.log(response.success);
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

function createDirectory(value) {
  //Luodaan kansio ajax kutsulla.
  var path = $('#adress').html();
  $.ajax({
    method: 'POST',
    url: urlcreateDirectory,
    data: { dir_name: value, creation_dir: path, _token: token },
    success: function success(response) {

      console.log(response.success); //Jos kansion luonti onnistuu, luodaan kansiorivi, johon sijoitetaan käyttäjän kirjoittama kansion nimi, sekä poisto painike.
      console.log(path);
      $('.directories').append($('<li></li>').attr('class', 'list-group-item folder').append($('<a></a>').attr('href', "/" + path + "/" + value).append($('<span>').attr('class', 'tab').append(path + "/" + value))).append($('<a>Delete</a>').attr({
        "class": "btn btn-danger btn-delete-folder pull-right",
        "href": "/delete-folder/" + path + "/" + value,
        "role": "button" })));
    },
    error: function error(response) {
      console.log(response.error);
    }
  });
}

function userDirectoryPrivileges(userID) {
  $.ajax({
    method: 'POST',
    url: '/user-directory-privileges',
    data: { userId: userID, _token: token },
    success: function success(response) {
      //$(response.success).appendTo(".directorylist");
      $('.directorylist').show(100, function () {
        $('.directorylist').html(response.success);
      });

      //$('.directory-list').html(ajaxresponse);
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
