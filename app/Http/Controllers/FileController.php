<?php

namespace Filebrowser\Http\Controllers;

use Illuminate\Http\Request;
use Filebrowser\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use app\Download;
use Storage;

class FileController extends Controller
{

  /**
      * Update the avatar for the user.
      *
      * @param  Request  $request
      * @return Response
      */

//Upload function
    public function upload(Request $request){

      if($request->hasFile('file')){                                            //Tarkistetaan onko käyttäjä valinnut lähetettävää tiedostoa.
        $this->validate($request, [                                             //Tarksitetaan onko lähetettävä tiedosto jokin seuraavista tiedostomuodoista.
          'file'  => 'required|mimetypes:image/jpeg,image/png,
          image/jpg,image/gif,image/svg+xml,text/plain|max:2048',
        ]);
        $polku = $request->invisible;                                           //Noudetaan piilotetun lomakekentän sisältö (polku)
        $file = $request->file('file');                                         //Tallennetaan lähetettävä tiedosto muuttujaan
        $filename = $file->getClientOriginalName();                             //Noudetaan tiedoston alkuperäinen nimi
        $request->file('file')->storeAs($polku, $filename);                     //Tallennetaan tiedosto luotuun $polku muuttujan sijaintiin, sekä tiedoston alkuperäisellä nimellä
        return back()->with('success', 'Tiedoston lähetys onnistui');           //Palautetaan käyttäjä sivulle, jossa hän oli.
      }
      else {                                                                    //Jos käyttäjä ei ole valinnut lähetettävää tiedostoa, palautetaan takaisin sivulle virheilmoituksen kanssa
        return back()->with('error', 'Valitse lähetettävä tiedosto');
      }
    }

//Delete function
    public function delete($file){
      Storage::delete($file);                                                   //Poistaa vastaanotetun tiedoston nimisen tiedoston.
      return back()->with('delete', 'Tiedoston poisto onnistui');               //Päivittää sivun ja lähetää mukana ilmoituksen onnistuneesta tiedoston poistosta
    }

  //Rename function
  public function rename(Request $request){
    $search = array("Å","å","Ä","ä","Ö","ö", " ");                                   //Muuttuja johon on sijoitettu lista kirjaimista, jotka korvataan.
    $replace = array("A","a","A","a","O","o", "_");                                  //Muuttuja johon on sijoitettu lista korvaavista kirjaimista.

    $old_name = $request['OldName'];                                            //Muuttuja johon noudetaan tiedoston vanha nimi
    $new_name = $request['NewName'];                                            //Muuttuja johon noudetaan tiedoston uusi nimi

    $new_name = str_replace($search, $replace, $new_name);                      //Tarkistetaan ja poistetaan tiedoston uudesta nimestä aikaisemmin määritellyt ääkköset
    $result = preg_replace('/[^a-zA-Z0-9-_\/.]/','', $new_name);                //Tarkistaa ja poistaa tiedoston uudesta nimestä kaikki erikoismerkit

    Storage::move($old_name,$result);                                           //Siirtää tiedoston nykyiseen sijaintiin uudella nimellä
    $newFileNameExpl = explode("/", $result);
    $newFileName = end($newFileNameExpl);
    return response()->json([                                                   //Palauttaa ajaxille tiedon nimenmuutoksen onnistumisesta/epäonnistumisesta, uuden nimen ja vanhan nimen.
                'old_name' => $old_name,
                'new_path' => $result,
                'new_name' => $newFileName,
                'success'  => "Nimi muutettu onnistuneesti",
                'error'    => "Virhe nimen muutossa"
            ]);
}

public function download($file) {
    return response()->download(storage_path('app/').$file);
}

}
