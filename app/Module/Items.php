<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Items extends Model
{
    protected $table = 'items';
    public $timestamps = true;
    protected $guarded = [];
        protected $primaryKey = 'id';

}
