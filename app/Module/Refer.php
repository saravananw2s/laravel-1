<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Refer extends Model
{
    protected $table = 'refer';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'ID';

}

