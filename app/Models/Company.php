<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companys';
    protected $primaryKey = 'id';
    public $timestamps = false;

}