<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lpk extends Model
{
    protected $table = 'lpk';
    public $timestamps = true;
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
