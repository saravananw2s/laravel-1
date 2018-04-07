<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Persons extends Model
{
    protected $table = 'Persons';
    public $timestamps = true;
    protected $guarded = [];
}
