<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id', 'attribute_type_id'];
    protected $fillable = ['name', 'code', 'description'];

    public function student_types()
    {
      return $this->belongsToMany('App\StudentType');
    }

    public function statuses()
    {
      return $this->hasMany('App\Status');
    }

    public function attribute_type()
    {
      return $this->belongsTo('App\AttributeType');
    }
}
