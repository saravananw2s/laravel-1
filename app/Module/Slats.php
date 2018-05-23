<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Slats extends Model
{
    protected $table = 'slots';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'ID';

}

