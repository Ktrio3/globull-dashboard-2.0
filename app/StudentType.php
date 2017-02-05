<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentType extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'code', 'description'];
}
