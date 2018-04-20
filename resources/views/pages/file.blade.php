<!-- This page is called when new file is inserted into system, it will create representation of that uploaded file -->
<li class="list-group-item clearfix file">
    <div class="row item-vertical-center">
        <div class="col-xs-7 itemSpans" data-filename="{{$path}}">
            <span class="fileIcon"><i class="far fa-file"></i></span>
            <span style="display:none;" class="oldFilePath">{{$path}}</span>
            <input type="text" class="fileNameInput form-control"></input>
            <span class="fileName">{{$fileName}}</span>
        </div>
        <div class="col-xs-5 itemButtons" data-filename="{{$path}}">
            <a href="/download/{{$path}}" class="btn btn-success download itemBtn" role="button"><i class="fas fa-download"></i></a>
            @if($user->user_privileges == 2)
            <button type="button" class="btn btn-warning cancel itemBtn" role="button"><i class="fas fa-ban"></i></button>
            <button type="button" class="btn btn-primary rename itemBtn" role="button"><i class="fas fa-font"></i></button>
            <button type="button" class="btn btn-success confirm itemBtn" role="button"><i class="far fa-check-circle"></i></button>
            <a href="/delete/{{$path}}" class="btn btn-danger btn-delete itemBtn" role="button"><i class="far fa-trash-alt"></i></a>
            @endif
        </div>
    </div>
</li>
