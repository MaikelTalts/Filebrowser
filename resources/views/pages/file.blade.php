<!-- This page is called when new file is inserted into system, it will create representation of that uploaded file -->
<li class='list-group-item file'>
  <span class="file_name">{{$fileName}}</span>
  @if($user->user_privileges == 2)
    <span style="display:none;" class="old_path">{{$path}}</span>
    <input type="text" class="file_name_input form-control col-xs-4"></input>
    <a href="/delete/{{$path}}" class="btn btn-danger btn-delete pull-right" role="button"><i class="far fa-trash-alt"></i></a>
    <button type="button" class="btn btn-primary pull-right rename" role="button"><i class="fas fa-font"></i></button>
    <button type="button" class="btn btn-warning pull-right cancel" role="button"><i class="fas fa-ban"></i></button>
    <button type="button" class="btn btn-success pull-right confirm"  role="button"><i class="far fa-check-circle"></i></button>
  @endif
  <a href="/download/{{$path}}" class="btn btn-success pull-right download" role="button"><i class="fas fa-download"></i></a>
</li>
