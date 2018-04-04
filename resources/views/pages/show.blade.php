<!-- "Noudetaan" Layouts kansion app nimisen tiedoston HTML määrittelyt -->
@extends('layouts.app')

<!-- Määritellään osio nimeltään [Content], joka lisätään aiemmin noudettuun app tiedostoon. -->
@section('content')



  <?php
  if($directories == null){
      $directories = Storage::Directories($directory);                                                                              //Tarkistetaan nykyisen kansion sisällä olevat kansiot
  }
    $files = Storage::Files($directory);                                                                                          //Tarkistetaan public kansion sisällä olevat tiedostot
  ?>

  @include('inc.breadcrumbs')
  @include('layouts.modal')                                                                                                       <!-- Noudetaan modaali -->

<div class="container text-left" id="container">                                                                                  <!-- Luodaan bootstrap elementti "container", sijoitetaan sisälle jäävät tekstit horisontaalisesti keskelle. -->
    <ul class="list-group directories">                                                                                           <!-- Luodaan visuaalinen taulukko kansioille -->
        @foreach ($directories as $key => $kansio)                                                                                <!-- Luupataan kansiorakenne läpi, ja tulostetaan sen käyttäjälle listana-->
          <?php
            $explFolderPath = explode("/", $kansio);
            $folderName = end($explFolderPath);
          ?>
          <li class="list-group-item folder">
            <a href="/{{$kansio}}"><span>{{$folderName}}</span></a>                                                                   <!-- Luodaan linkkipolku, seuraavaan tiedostopolun kansioon -->
            @if($userPrivileges == 2)
            <a href="/delete-folder/{{$kansio}}" class="btn btn-danger btn-delete-folder pull-right" role="button"><i class="far fa-trash-alt"></i></a>
            @endif
            <a href="/download-zip/{{$kansio}}" class="btn btn-success pull-right" role="button"><i class="fas fa-download"></i></a>
          </li>
        @endforeach
    </ul>
    <ul class="list-group">                                                                                                       <!-- Luodaan visuaalinen taulukko tiedostoille -->
        @foreach ($files as $key => $file)                                                                                        <!-- Luupataan nykyisen kansion tiedostot ja tulostetaan ne nkäyttäjälle listana -->
          <?php
            $fileExpl = explode("/", $file);
            $fileName = end($fileExpl);
           ?>
          <li class='list-group-item file'>
            <span class="file_name">{{ $fileName }}</span>
            @if($user->user_privileges == 2)
              <span style="display:none;" class="old_path">{{$file}}</span>
              <input type="text" class="file_name_input form-control col-xs-4"></input>
              <a href="/delete/{{$file}}" class="btn btn-danger btn-delete pull-right" role="button"><i class="far fa-trash-alt"></i></a>                     <!-- Tiedostojen [poiston] suorittava painike -->
              <button type="button" class="btn btn-primary pull-right rename" role="button"><i class="fas fa-font"></i></button>                         <!-- Tiedostojen uudelleennimeämisen aloittava painike, tuo seuraavat kaksi painiketta esille [Cancel] & [Confirm]  ja piilottaa kaikki [Rename] painikkeet-->
              <button type="button" class="btn btn-warning pull-right cancel" role="button"><i class="fas fa-ban"></i></button>                         <!-- [Cancel] painike joka peruuttaa keskeneräisen nimeämisprosessin -->
              <button type="button" class="btn btn-success pull-right confirm"  role="button"><i class="far fa-check-circle"></i></button>                      <!-- Hyväksyy nykyisen uudelleennimeämisen, aloittaa Jquery ajax toiminnon -->
            @endif
            <a href="/download/{{$file}}" class="btn btn-success pull-right download" role="button"><i class="fas fa-download"></i></a>
          </li>
        @endforeach
      </ul>
</div>
<div class="container">
    <div class="row">
      <div class="col-md-offset-6 col-md-6">
          <a href="/" class="btn btn-default pull-right btn-home"><i class="fas fa-home glyphicon"></i></a>
          <button type="button" class="btn btn-default pull-right btn-home" data-toggle="modal" data-target="#infoModal"><i class="far fa-question-circle glyphicon"></i></button>
          @if($user->user_upload_privilege == 2)
            <button type="button" class="btn btn-default btn-home pull-right" data-toggle="modal" data-target="#fileModal"><i class="far fa-file-alt newItem"></i></button>
            <button type="button" class="btn btn-default btn-home pull-right" data-toggle="modal" data-target="#directoryModal"><i class="far fa-folder newItem"></i></button>
            @endif
      </div>
    </div>
</div>
<!-- ilmoitus tiedoston onnistuneesta nimenmuutoksesta -->
<div class="alert alert-success alert-dismissable fade in rename-notification text-center" id="rename_notification_success">
  <span class="close" id="notification_close-success" aria-label="close">&times;</span>                                 <!-- Ilmoituskentän sulkemista varten tarkoitettu rasti -->
    <center><div class="loader" id="loader1"></div></center>                                                                    <!-- [PRELOADER] elementti, joka tuodaan näkyville app.js sivulla -->
    <strong id="upload_message">Rename completed</strong>                                                                       <!-- Onnistuneesta nimenmuutoksesta kertova teksti, joka tuodaan esille app.js sivulla -->
</div>
<!-- Ilmoitus virheellisestä nimenmuutosta -->
<div class="alert alert-danger alert-dismissable fade in rename-notification text-center" id="rename_notification_danger">
    <span class="close" id="notification_close-danger" aria-label="close">&times;</span>
                                    <!-- Ilmoituskentän sulkemista varten tarkoitettu rasti -->
    <strong>Filename was not changed</strong>                                                                                   <!-- Virheellisestä nimenmuutoksesta kertova teksti, joka tuodaan esille yhdessä danger ilmoituksen kanssa -->
</div>


@endsection                                                                                                                     <!-- Päätetään osio nimeltään content -->
