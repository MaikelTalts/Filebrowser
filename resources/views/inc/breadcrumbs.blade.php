@if (Auth::check())
<div class="container text-center">                                             <!-- Luodaan joka sivun yläosassa näkyvä container, jonka sisällä olevat tekstit keskitetään -->
    <div class="jumbotron header-tron">                                         <!-- Luodaan bootstrap tyylitelty div elementti (jumbotron) -->
        <h1>Filebrowser</h1>
        <nav aria-label="breadcrumb">                                           <!-- Breadcrumbs are created with received $directory address, witch will be exploded used as folder path -->
          <ol class="breadcrumb">
            <?php
              $path = "";
              $explodeDir = explode("/", $directory);
              $countDir = count($explodeDir);
              $lastDir = end($explodeDir);
              foreach($explodeDir as $directory){
                $path = $path . "/" . $directory ;
                if($directory == $lastDir){
                  echo "<li class='breadcrumb-item active' aria-current='page' id='currentPath' value='$path'>$directory</li>";
                }
                else{
                  echo "<li class='breadcrumb-item active' aria-current='page'><a href='http://localhost:8000/$path'>$directory</a></li>";
                }
              }
             ?>
          </ol>
        </nav>
    </div>
</div>
@endif
