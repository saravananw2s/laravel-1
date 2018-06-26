<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class ventor extends Model
{
    protected $table = 'ventorlogin';
    public $timestamps = true;
    protected $guarded = [];
        protected $primaryKey = 'id';

}
