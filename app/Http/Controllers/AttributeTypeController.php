<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AttributeType;

class AttributeTypeController extends Controller
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
        return view('admin.attribute_types.attribute_types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $attributeType = new AttributeType();
        return view('admin.attribute_types.create_attribute_type', array('attributeType' => $attributeType));
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
      $attributeType = AttributeType::create($request->only(['name', 'description']));

      return redirect()->route('attribute-types.index')->with('status', 'Attribute Type created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $attributeType = attributeType::findOrFail($id);
        return view('admin.attribute_types.update_attribute_type', array('attributeType' => $attributeType));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //
      $attribute = AttributeType::findOrFail($id)->fill($request->only(['name', 'description']));
      $attribute->save();

      return redirect()->route('attribute-types.index')->with('status', 'Attribute Type updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
