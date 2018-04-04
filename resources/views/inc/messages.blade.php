<div class="container text-center" id="container">                                <!-- Div elementti joka sisältää kaikki onnistuneet ja epäonnistuneet ilmoitusket -->
@if(session('success'))                                                           <!-- Jos tiedoston lähetys onnistui, palautuu istunnolle 'success' -->
  <div class="alert alert-success alert-dismissable">                             <!-- Bootstrap alert elementti, jonka sisälle sijoitetaan käyttäjälle näytettävä teksti -->
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <!-- ilmoituksen sulkeva rasti -->
    <strong>{{session('success')}} </strong>                                      <!-- Tulostetaan vastaaanotetun succesin teksti -->
  </div>
@endif


@if(session('error'))                                                             <!-- Jos tiedoston lähetys epäonnistui, palautuu istunnolle 'error' -->
  <div class="alert alert-danger alert-dismissable">                              <!-- Bootstrap alert elementti, jonka sisälle sijoitetaan käyttäjälle näytettävä teksti -->
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <!-- ilmoituksen sulkeva rasti -->
    <strong>{{session('error')}}</strong>                                         <!-- Tulostetaan vastaaanotetun errorin teksti -->
  </div>
@endif

@if(session('delete'))                                                            <!-- Jos tiedoston poisto onnistui, palautuu istunnolle 'delete' -->
  <div class="alert alert-success alert-dismissable">                             <!-- Bootstrap alert elementti, jonka sisälle sijoitetaan käyttäjälle näytettävä teksti -->
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <!-- ilmoituksen sulkeva rasti -->
    <strong>{{session('delete')}}</strong>                                        <!-- Tulostetaan vastaaanotetun deleten teksti -->
  </div>
@endif
</div>
