<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id', 'attribute_id'];
    protected $fillable = ['name', 'code', 'description'];

    public function attribute()
    {
      return $this->belongsTo('App\Attribute');
    }
}
