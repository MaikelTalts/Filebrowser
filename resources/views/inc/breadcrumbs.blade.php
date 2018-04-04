@if (Auth::check())
<div class="container text-center">                                             <!-- Luodaan joka sivun yläosassa näkyvä container, jonka sisällä olevat tekstit keskitetään -->
    <div class="jumbotron header-tron">                                            <!-- Luodaan bootstrap tyylitelty div elementti (jumbotron) -->
        <h1>Filebrowser</h1>
          <ul class="breadcrumb">
          </ul>
        <p id="adress" style="display:none;">{{@$directory}}</p>                <!-- Sijoitetaan nykyinen sijainti piilotettuun paragraphiin -->
    </div>
</div>
@endif
