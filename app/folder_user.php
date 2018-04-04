<?php

namespace Filebrowser;

use Illuminate\Database\Eloquent\Model;
use Filebrowser\User;

class folder_user extends Model
{
    protected $table = 'folder_users';
    public $primaryKey = 'id';

    public function user(){
      return $this->belongsToMany('Filebrowser\User');
    }

    public function folder(){
      return $this->belongsToMany('Filebrowser\Folder');
    }
}
