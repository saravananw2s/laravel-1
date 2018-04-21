<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Orders extends Model
{
    protected $table = 'Orders';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}
