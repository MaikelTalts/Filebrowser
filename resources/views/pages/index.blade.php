@extends('layouts.app')                                                                                                           <!-- Define that this page extend layouts/app.blade.php -->
<!-- Minor change -->
@section('content')                                                                                                               <!-- Define section named [Content] witch is included in app.blade.php page -->

  <?php
    $directory = "public";                                                                                                        //Save the current path inside variable, witch can be used later
    //$directories = Storage::Directories('public/');                                                                             //Check all folders inside current directory
    $files = Storage::Files('public/');                                                                                           //Check all files inside public location
  ?>

  @include('inc.breadcrumbs')                                                                                                     <!-- Receivel a breadcrumbs file that includes filepath -->
<div class="container text-left" id="container">
    <ul class="list-group directories">                                                                                           <!-- Create visual table for folders -->
        @foreach ($directories as $key => $dir)                                                                                   <!-- Loop through all folders in current directory -->
          <li class="list-group-item folder">                                                                                     <!-- Create link as path to next directory -->
            <a href="/{{env('ROOTFOLDER')}}{{$dir->folder_name}}"><span>{{$dir->folder_name}}</span></a>
            @if($user->user_privileges == 2)                                                                                      <!-- Check if current user has value 2 in user_privileges table row -->
            <a href="/delete-folder/{{env('ROOTFOLDER').$dir->folder_name}}" class="btn btn-danger btn-delete-folder pull-right" role="button"><i class="far fa-trash-alt"></i></a>     <!-- Delete folder button -->
            @endif
            <a href="/download-zip/{{env('ROOTFOLDER').$dir->folder_name}}" class="btn btn-success pull-right" role="button"><i class="fas fa-download"></i></a>    <!-- Download button for entire directory -->
          </li>
        @endforeach
    </ul>
    <ul class="list-group files">                                                                                                       <!-- Create visual table for files -->
        @foreach ($files as $key => $file)                                                                                        <!-- Loop through all files in current folder location, and print them to user -->
          <?php
            $fileExpl = explode("/", $file);                                                                                      //Breaks the file path into separate folders / files
            $fileName = end($fileExpl);                                                                                           //Uses the last value in table
           ?>
          <li class='list-group-item file'>
            <span class="file_name">{{$fileName}}</span>                                                                                                 <!-- Creates span with filename -->
            @if($user->user_privileges == 2)                                                                                                             <!-- Check if current user has value 2 in user_privileges table row -->
              <span style="display:none;" class="old_path">{{$file}}</span>                                                                              <!-- Save current file old path to hidden span -->
              <input type="text" class="file_name_input form-control col-xs-4"></input>                                                                  <!-- Input for changing the file name -->
              <a href="/delete/{{$file}}" class="btn btn-danger btn-delete pull-right" role="button"><i class="far fa-trash-alt"></i></a>                <!-- Delete file -->
              <button type="button" class="btn btn-primary pull-right rename" role="button"><i class="fas fa-font"></i></button>                         <!-- Starts renaming, shows cancel and confirm buttons, after clicking and hides all rename buttons -->
              <button type="button" class="btn btn-warning pull-right cancel" role="button"><i class="fas fa-ban"></i></button>                          <!-- Cancel renaming-->
              <button type="button" class="btn btn-success pull-right confirm"  role="button"><i class="far fa-check-circle"></i></button>               <!-- Accept renaming -->
            @endif
            <a href="/download/{{$file}}" class="btn btn-success pull-right download" role="button"><i class="fas fa-download"></i></a>                  <!-- Download button for current file -->
          </li>
        @endforeach
    </ul>
</div>
<div class="container">
    <div class="row">
      <div class="col-md-offset-6 col-md-6">
          <button type="button" class="btn btn-default pull-right btn-home" data-toggle="modal" data-target="#infoModal"><i class="far fa-question-circle glyphicon"></i></button>    <!-- Help/ Info modal toggle button -->
          @if($user->user_upload_privilege == 2)                                                                                                                                      <!-- Check if current user has value 2 in user_privileges table row -->
            <button type="button" class="btn btn-default btn-home pull-right" data-toggle="modal" data-target="#fileModal"><i class="far fa-file-alt newItem"></i></button>           <!-- Add new file button -->
            <button type="button" class="btn btn-default btn-home pull-right" data-toggle="modal" data-target="#directoryModal"><i class="far fa-folder newItem"></i></span></button> <!-- Add new folder button -->
          @endif
      </div>
    </div>
</div>

<div class="alert alert-success alert-dismissable fade in rename-notification text-center" id="rename_notification_success">    <!-- Alert for successful file renaming -->
    <span class="close" id="notification_close-success" aria-label="close">&times;</span>                                       <!-- Button for closing the alert -->
    <center><div class="loader" id="loader1"></div></center>                                                                    <!-- Preloader -->
    <strong id="upload_message">Rename completed</strong>                                                                       <!-- Message -->
</div>

<div class="alert alert-danger alert-dismissable fade in rename-notification text-center" id="rename_notification_danger">      <!-- Alert for unsuccessful rename event -->
    <span class="close" id="notification_close-danger" aria-label="close">&times;</span>                                        <!-- Button for closing the alert -->
    <strong>Filename was not changed</strong>                                                                                   <!-- Message -->
</div>
<!-- Minor change -->

@endsection                                                                                                                     <!-- End content -->
