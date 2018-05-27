<?php

namespace App\Module;

use Illuminate\Database\Eloquent\Model;
class myoffers extends Model
{
    protected $table = 'myoffers';
    public $timestamps = true;
    protected $guarded = [];
        protected $primaryKey = 'id';

}
