<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeType extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'description', 'precedence'];

    public function attributes()
    {
      return $this->hasMany('App\Attribute');
    }
}
