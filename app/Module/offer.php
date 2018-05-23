<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class offer extends Model
{

    protected $table = 'offers';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';



}





