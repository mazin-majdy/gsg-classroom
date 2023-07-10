<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::orderBy('created_at', 'DESC')->get(); // return Collection of Classroom

        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->except('name', 'cover_image'));
        // dd($request->only('name', 'cover_image'));

        // Method 1
        // $classroom = new Classroom();

        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');
        // $classroom->code = Str::random(8);

        // $classroom->save();

        // Method 2: Mass assignment


        // $data = $request->all();
        // $data['code'] = Str::random(8);

        $request->merge([
            'code' => Str::random(8)
        ]);
        $classroom = Classroom::create($request->all());

        // Alternative for Mass assignment
        // $classroom = new Classroom($request->all());
        // $classroom->save();

        // $classroom = new Classroom();
        // $classroom->fill($request->all())->save();
        // $classroom->forceFill($request->all())->save();

        //PRG => Post Redirect Get

        return redirect()->route('classrooms.index');
    }

    public function show(string $id)
    {
        // Classroom ::where('id', '=', $id)->first(); same result
        $classroom = Classroom::findOrFail($id);

        return view('classrooms.show', compact('classroom'));
    }


    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        // same as findOrFail
        // if(!$classroom){
        //     abort(404);
        // }
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, $id)
    {

        // Method 1
        $classroom = Classroom::findOrFail($id);

        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');

        // $classroom->save(); // update

        // Mass assignment
        $classroom->update($request->all());
        // $classroom->fill($request->all())->save();

        return Redirect::route('classrooms.index');
    }

    public function destroy($id)
    {
        // Classroom::where('id', '=', $id)->delete(); // Same Result
        $count = Classroom::destroy($id);

        // $classroom = Classroom::find($id);
        // $classroom->delete();

        return redirect(route('classrooms.index'));
    }
}
