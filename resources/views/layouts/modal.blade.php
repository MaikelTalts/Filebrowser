<!-- INFO Modal -->
  <div class="modal fade" id="infoModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content text-center">                                   <!-- Ohjeet sivustolla liikkumiseen ja toimintoihin -->
        <div class="modal-header">
          <h4 class="modal-title">Filebrowser</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid" style="text-align:left;">
            <strong>Selaimessa liikkuminen</strong>
            <p>Liiku kansiorakenteessa klikkaamalla kansioiden nimiä, tiedostojen tallennus ja poisto tapahtuvat aina sen hetkisessä sijainnissa.</p>
            <strong>Tiedoston läheys</strong>
            <p>Klikkaa choose file painiketta.<br>Valitse avautuvassa ruudussa tiedosto, jonka halaut lähettää, ja valitse [Avaa].<br>Klikkaa vielä [Upload file] painiketta, jolloin tiedosto siirtyy palvelimelle.</p>
            <strong>Tiedostojen uudelleennimeäminen</strong>
            <p>Klikkaa [Rename] painiketta, muuta teksikenttään haluamasi nimi ja klikkaa [Confirm].</p>
            <strong>Tiedostojen poisto</strong>
            <p>Klikkaa delete painiketta riviltä, jolta haluat poistaa tiedoston, hyväksy vielä varmenne ja tiedosto poistuu.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- FILE UPLOAD -->
    <div class="modal fade" id="fileModal" role="dialog">                       <!-- Tiedostojen lähettäminen palvelimelle -->
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h4 class="modal-title">Upload file</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid" style="text-align:left;">
                {!! Form::open(['url' => '/upload', 'method' => 'POST', 'files' => true, 'enctype' => 'multipart/form-data']) !!}       <!-- Luodaan lomake, jonka metodi on (POST) ja action (/uplaod), joka reitittää toiminnon web.php kautta -->
                  {{Form::file('file')}}<br>                                                                                            <!-- Tiedostonvalinta -->
                  {{Form::hidden('invisible', @$directory) }}                                                                            <!-- Piilotettu lomakekenttä, uplaodControlleria varten (voidaan noutaa nykyinen sijainti) -->
                  {{Form::submit('Upload file', ['class' => 'btn btn-info filebtn'])}}                                                  <!-- Luodaan lomakkeen hyväksyvä painike -->
                {!! Form::close() !!}                                                                                                   <!-- Suljetaan lomake -->
            </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- NEW DIRECTORY -->
    <div class="modal fade" id="directoryModal" role="dialog">                  <!-- Kansioiden luominen palvelimelle -->
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h4 class="modal-title">Create new directory</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <br>
              <input type="text" class="form-control" placeholder="Folder name" id="directoryName" style="width:100%;"></input>
              <br>
              <button type="button" class="btn btn-success btn-create-directory" role="button">Create</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
    </div>


  <!-- USER CONTROL -->
  <div class="modal fade" id="userControlModal" role="dialog">

    </div>

  <!-- Notification bar -->
  <div id="notificationBar">Notification text...</div>
