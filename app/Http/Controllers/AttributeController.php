<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Status;
use App\AttributeType;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth.modder', ['except' => [
             'index',
             'barAction',
         ]]);
     }


    public function index()
    {
        //
        return view('admin.attributes.attributes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $attribute = new Attribute();
        return view('admin.attributes.create_attribute', array('attribute' => $attribute));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $attribute = Attribute::create($request->only(['name', 'code', 'description', 'is_info']));

        $is_info = $request->get('is_info');

        //Create the info status
        if($is_info)
        {
          $newStatus = new Status();
          $newStatus->name = $attribute->name;
          $newStatus->code = $attribute->code . '-fillable';
          $newStatus->complete = 1;
          $newStatus->description = $attribute->description;
          $attribute->statuses()->save($newStatus);
        }

        $statuses = $request->only('statuses');

        if(!$is_info && !empty($statuses['statuses']))
        {
          $statuses = $statuses['statuses'];

          foreach($statuses as $status)
          {
            $newStatus = new Status();
            $newStatus->name = $status['name'];
            $newStatus->code = $status['code'];
            $newStatus->description = $status['description'];

            if(isset($status['complete']) && $status['complete'] == 1)
              $newStatus->complete = $status['complete'];
            else
              $newStatus->complete = 0;

            $attribute->statuses()->save($newStatus);
          }
        }

        //Save type
        $attributeTypeID = $request['attribute_type'];

        $attributeType = AttributeType::findOrFail($attributeTypeID);

        $attribute->attribute_type()->associate($attributeType);

        $attribute->save();

        return redirect()->route('attributes.index')->with('status', 'Attribute created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
      // Don't need to show an attribute individually currently.
      // Possibly in future, show information and student statistics for this type?
      return view('admin.attributes.attributes');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        //
        return view('admin.attributes.update_attribute', array('attribute' => $attribute));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        //
        $attribute->fill($request->only(['name', 'code', 'description', 'is_info']));
        $attribute->save();

        $is_info = $request->get('is_info');

        //Create the info status, if not already created
        if($is_info && !Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->exists())
        {
          $newStatus = new Status();
          $newStatus->name = $attribute->name;
          $newStatus->code = $attribute->code . '-fillable';
          $newStatus->description = $attribute->description;
          $newStatus->complete = 1;
          $attribute->statuses()->save($newStatus);
        }
        else if(!$is_info && Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->exists())
        {
          Status::where('code', $attribute->code . '-fillable')->where('attribute_id', $attribute->id)->delete();
        }

        $statuses = $request->only('statuses');

        if(!$is_info && !empty($statuses['statuses']))
        {
          $statuses = $statuses['statuses'];
          $status_ids = [];

          foreach($statuses as $status)
          {
            //Grab id's that should be kept
            if($status['id'] != -1)
            {
              $status_ids[] = $status['id'];

              //Update
              $newStatus = Status::findOrFail($status['id']);

              $newStatus->name = $status['name'];
              $newStatus->code = $status['code'];
              $newStatus->description = $status['description'];

              if(isset($status['complete']) && $status['complete'] == 1)
                $newStatus->complete = $status['complete'];
              else
                $newStatus->complete = 0;

              $newStatus->save();
            }
            else{
              //Create new
              $newStatus = new Status();
              $newStatus->name = $status['name'];
              $newStatus->code = $status['code'];
              $newStatus->description = $status['description'];

              if(isset($status['complete']) && $status['complete'] == 1)
                $newStatus->complete = $status['complete'];
              else
                $newStatus->complete = 0;

              $attribute->statuses()->save($newStatus);

              $status_ids[] = $newStatus->id;
            }
          }

          //These are the ids to keep in the database -- remove other statuses
          if(!empty($status_ids))
          {
              Status::whereNotIn('id', $status_ids)->where('attribute_id', $attribute->id)->delete();
          }
        }

        //Save type
        $attributeTypeID = $request['attribute_type'];

        $attributeType = AttributeType::findOrFail($attributeTypeID);

        $attribute->attribute_type()->associate($attributeType);

        $attribute->save();

        return redirect()->route('attributes.index')->with('status', 'Attribute updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        //Not sure what to do with destroy just yet
    }
}
