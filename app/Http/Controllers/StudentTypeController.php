<?php

namespace App\Http\Controllers;

use App\StudentType;
use Illuminate\Http\Request;

class StudentTypeController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.modder', ['except' => [
            'index',
            'barAction',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Available to ALL users
        return view('admin.student_types.student_types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Only available to modders
        $student_type = new StudentType();

        return view('admin.student_types.create_student_type', array('student_type' => $student_type));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StudentType $student_type)
    {
        //Only available to modders
        $student_type = StudentType::create($request->only(['name', 'code', 'description']));

        if(!empty($request['attributes']))
          $student_type->attributes()->sync($request['attributes']);

        return redirect()->route('student-types.index')->with('status', 'Student Type created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentType  $studentType
     * @return \Illuminate\Http\Response
     */
    public function show(StudentType $student_type)
    {
        // Don't need to show a student type individually currently.
        // Possibly in future, show information and student statistics for this type?
        return view('admin.student_types.student_types');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentType  $studentType
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentType $student_type)
    {
        //Only available to modders
        return view('admin.student_types.update_student_type', array('student_type' => $student_type));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentType  $studentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentType $student_type)
    {
        //Only available to modders
        $student_type->fill($request->only(['name', 'code', 'description']));
        $student_type->save();

        $student_type->attributes()->sync($request['attributes']);

        return redirect()->route('student-types.index')->with('status', 'Student Type updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentType  $studentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentType $student_type)
    {
        //Not sure what to do with destroy just yet
    }
}
