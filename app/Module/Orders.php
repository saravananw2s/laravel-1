<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class Orders extends Model
{
    protected $table = 'Orders';
    public $timestamps = true;
    protected $guarded = [];
}
