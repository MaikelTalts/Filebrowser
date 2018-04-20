@extends('layouts.app')                                                                                                           <!-- Define that this page extend layouts/app.blade.php -->

@section('content')                                                                                                               <!-- Define section named [Content] witch is included in app.blade.php page -->

  <?php
  if($directories == null){                                                                                                       //Check if received $directories variable is null, then check all directories from received path in $directory variable
      $directories = Storage::Directories($directory);
  }
    $files = Storage::Files($directory);                                                                                          //Check all folders inside current directory
  ?>

  @include('inc.breadcrumbs')                                                                                                     <!-- Receivel a breadcrumbs file that includes filepath -->
<div class="container text-left" id="container">
  <ul class="list-group directories">
      @foreach ($directories as $key => $kansio)                                                                                <!-- Loop through all folders in current directory -->
        <?php
          $explFolderPath = explode("/", $kansio);                                                                              //Breaks the directory path into separate folders
          $folderName = end($explFolderPath);                                                                                   //Uses the last value in table
        ?>
        <li class="list-group-item clearfix folder">
            <div class="row item-vertical-center">

                <div class="col-xs-7">
                  <span class="folderIcon"><i class="far fa-folder"></i></span>
                  <a href="/{{$kansio}}"><span>{{$folderName}}</span></a>                                                               <!-- Create link as path to next directory -->
                </div>

                <div class="col-xs-5 itemButtons">
                  <a href="/download-zip/{{$kansio}}" class="btn btn-success itemBtn" role="button"><i class="fas fa-download"></i></a>                        <!-- Download button for entire directory -->
                  @if($user->user_privileges == 2)                                                                                             <!-- Check if current user has value 2 in user_privileges table row -->
                  <a href="/delete-folder/{{$kansio}}" class="btn btn-danger btn-delete-folder itemBtn" role="button"><i class="far fa-trash-alt"></i></a>     <!-- Delete folder button -->
                  @endif
                </div>
            </div>
        </li>
      @endforeach
    </ul>
    <ul class="list-group files">
      @foreach ($files as $key => $file)                                                                                        <!-- Loop through all files in current folder location, and print them to user -->
        <?php
          $fileExpl = explode("/", $file);                                                                                      //Breaks the file path into separate folders / files
          $fileName = end($fileExpl);                                                                                           //Uses the last value in table
         ?>
        <li class="list-group-item clearfix file">
            <div class="row item-vertical-center">
                <div class="col-xs-7 itemSpans" data-filename="{{$file}}">
                    <span class="fileIcon"><i class="far fa-file"></i></span>
                    <span style="display:none;" class="oldFilePath">{{$file}}</span>                                                                         <!-- Save current file old path to hidden span -->
                    <input type="text" class="fileNameInput form-control"></input>                                                                           <!-- Input for changing the file name -->
                    <span class="fileName">{{$fileName}}</span>
                </div>
                <div class="col-xs-5 itemButtons" data-filename="{{$file}}">
                    <a href="/download/{{$file}}" class="btn btn-success download itemBtn" role="button"><i class="fas fa-download"></i></a>                <!-- Download button for current file -->
                    @if($user->user_privileges == 2)                                                                                                        <!-- Check if current user has value 2 in user_privileges table row -->
                    <button type="button" class="btn btn-warning cancel itemBtn" role="button"><i class="fas fa-ban"></i></button>                          <!-- Cancel renaming-->
                    <button type="button" class="btn btn-primary rename itemBtn" role="button"><i class="fas fa-font"></i></button>                         <!-- Starts renaming, shows cancel and confirm buttons, after clicking and hides all rename buttons -->
                    <button type="button" class="btn btn-success confirm itemBtn" role="button"><i class="far fa-check-circle"></i></button>                <!-- Accept renaming -->
                    <a href="/delete/{{$file}}" class="btn btn-danger btn-delete itemBtn" role="button"><i class="far fa-trash-alt"></i></a>                <!-- Delete file -->
                    @endif
                </div>
            </div>
        </li>
      @endforeach
    </ul>
</div>
<div class="container text-right">
    <div class="row">
      <div class="col-md-offset-6 col-md-6">
          @if($user->user_upload_privilege == 2)                                                                                                                                      <!-- Check if current user has value 2 in user_privileges table row -->
            <button type="button" class="btn btn-default btn-home" data-toggle="modal" data-target="#directoryModal"><i class="far fa-folder newItem"></i></span></button>            <!-- Add new folder button -->
            <button type="button" class="btn btn-default btn-home" data-toggle="modal" data-target="#fileModal"><i class="far fa-file-alt newItem"></i></button>                      <!-- Add new file button -->
          @endif
          <button type="button" class="btn btn-default btn-home" data-toggle="modal" data-target="#infoModal"><i class="far fa-question-circle glyphicon"></i></button>               <!-- Help/ Info modal toggle button -->
          <a href="/" class="btn btn-default btn-home"><i class="fas fa-home glyphicon"></i></a>
      </div>
    </div>
</div>

@endsection                                                                                                                     <!-- End content -->
