<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Persons extends Model
{
    protected $table = 'Persons';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}
