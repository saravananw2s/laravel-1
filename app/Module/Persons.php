<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persons extends Model
{
	    use SoftDeletes;

    protected $table = 'Persons';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}
