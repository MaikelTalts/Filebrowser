<!DOCTYPE html>                                                                 <!-- Aloitetaan HTML -->
<html lang="{{ app()->getLocale() }}">                                          <!-- Tarkistetaan paikallinen kieli -->
<head>                                                                          <!-- Aloitetaan HEAD osio, johon tuodaan meta tiedot sekä tarvittavat linkitykset -->
    <meta charset="utf-8">                                                      <!-- Esitetään merkistöstandardi -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">        <!-- Ruudunkoko metatietoja -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">                     <!-- Linkitys tyylittelytiedostoon, kansiossa CSS, tiedosto app.css -->
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>   <!-- JQuery -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">                       <!-- CSRF-TOKEN -->
    <title>{{ config('app.name', 'Filebrowser') }}</title>
</head>
<body>                                                                          <!-- Aloitetaan body osio -->
    <div id="app">
        @include('layouts.modal')
        @include('inc.nav')
        @include('inc.messages')                                                <!-- Noudetaan ilmoitukset -->
        @yield('content')

    </div>

    <script src="{{asset('js/app.js')}}"></script>                              <!-- Noudetaan oma custom javascript tiedosto -->
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    <script>
      var token = "{{Session::token()}}";                                       //Muuttujaan sijoitettu istunnon CSRF token.
      var urlRename = '{{route('rename')}}';                                    //Muuttujaan sijoitettu url, jonka ajax toiminto noutaa.
      var urlPrivilege = '{{route('updateUserStatus')}}';
      var urlDeleteUser = '{{route('DeleteUser')}}';
      var urlcreateDirectory = '{{route('createDirectory')}}';
    </script>
</body>
</html>
