<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class history extends Model
{

    protected $table = 'orders_history';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';



}
