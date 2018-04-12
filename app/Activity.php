<?php

namespace Filebrowser;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = ['actor', 'act', 'object', 'target', 'preposition', 'result'];
}
