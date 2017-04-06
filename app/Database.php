<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'driver', 'host', 'port', 'database', 'username',
            'password', 'table', 'uid_column', 'student_type'];

    public function attributes()
    {
      return $this->belongsToMany('App\Attribute')->withPivot(['column']);
    }
}
