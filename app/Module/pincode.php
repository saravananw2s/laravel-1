<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pincode extends Model
{

    protected $table = 'pincodes';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';



}
