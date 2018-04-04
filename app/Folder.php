<?php

namespace Filebrowser;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
      'folder_name'
    ];

    public function users(){
      return $this->belongsToMany('Filebrowser\User', 'folder_user', 'user_id', 'folder_id');
}
}
