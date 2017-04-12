<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Database;
use App\StudentType;
use App\Attribute;

class DatabaseController extends Controller
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
        return view('admin.database.databases');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        //
        $database = new Database();
        return view('admin.database.create_database', array('database' => $database));
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
      $database = Database::create($request->all());

      return redirect()->route('database.index')->with('status', 'Database created!');
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
        $database = Database::find($id);
        return view('admin.database.edit_database', array('database' => $database));
    }

    public function edit_attributes($id)
    {
        $database = Database::find($id);
        return view('admin.database.edit_database_attributes', array('database' => $database));
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
      $database = Database::findOrFail($id);
      $remove_attributes = False;
      if($request->get('student_type') != $database->student_type)
        $remove_attributes = True;

      $database->fill($request->all());

      if($remove_attributes)
        $database->attributes()->detach(); //Remove all attributes as student type updated

      $database->save();

      return redirect()->route('database.index')->with('status', 'Database updated!');
    }

    public function update_attributes(Request $request, $id)
    {
      $database = Database::findOrFail($id);

      $syncAttr = [];

      $attributes = $request->get('attributes');

      foreach($attributes as $attribute)
      {
        //Test that attribute exists, then add
        Attribute::findOrFail($attribute['attribute'])->whereHas('student_types', function ($query) use ($database) {$query->where('student_types.id', $database->student_type);});
        $syncAttr[$attribute['attribute']] = ['column' => $attribute['column']];
      }

      $database->attributes()->sync($syncAttr);

      return redirect()->route('database.edit', ['id' => $database->id])->with('status', 'Database attributes updated!');
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
