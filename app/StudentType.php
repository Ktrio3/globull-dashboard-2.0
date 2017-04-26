<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentType extends Model
{
    //
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'code', 'description'];

    public function attributes()
    {
      return $this->belongsToMany('App\Attribute');
    }

    public function attribute_types()
    {
      $attribute_types = [];

      //Foreach attribute, add their type, if not already added
      foreach($this->attributes()->get() as $attribute)
      {
        $attributeType = $attribute->attribute_type()->first();
        if(!in_array($attributeType, $attribute_types))
          $attribute_types[] = $attributeType;
      }

      usort($attribute_types, function($a, $b){
        if ($a->precedence == $b->precedence) {
          if($a->name == $b->name)
            return 0;
          return ($a->name < $b->name) ? -1 : 1;
        }
        return ($a->precedence > $b->precedence) ? -1 : 1;
      });

      return $attribute_types;
    }

    public function student()
    {
      return $this->belongsToMany('App\Student');
    }

    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id)
            ->get();
    }
}
