<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    //
    public $timestamps = true;
    protected $guarded = ['id'];

    public function statuses()
    {
      return $this->belongsToMany('App\Status')->withPivot(['message', 'value']);
    }

    public function student_types()
    {
      return $this->belongsToMany('App\StudentType');
    }

    public function attributes()
    {
      return $this->manyThroughMany('App\Attribute', 'App\StudentType', 'student_type_id', 'id' , 'attribute_id');
    }

    public function attribute_types()
    {
      $student_types = $this->student_types; //Get the student's types

      $attribute_types = [];

      //For each type, get their attributes
      foreach($student_types as $type)
      {
        //Foreach attribute, add their type, if not already added
        foreach($type->attributes()->get() as $attribute)
        {
          $attributeType = $attribute->attribute_type()->first();
          if(!in_array($attributeType, $attribute_types))
            $attribute_types[] = $attributeType;
        }
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
