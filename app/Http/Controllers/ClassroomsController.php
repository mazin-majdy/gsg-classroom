<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ClassroomsController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::orderBy('created_at', 'DESC')->get(); // return Collection of Classroom


        // session()->get('success');
        // Session::get('success');
        $success = session('success'); // return value of success in the session
        // Session::put('success', 'whatever!');
        // Session::flash('success', 'Whatever!');
        // Session::remove('success');
        return view('classrooms.index', compact('classrooms', 'success'));
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

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image'); //Uploaded File
            // $path = $file->storeAs('/covers', 'name.png', 'uploads');
            // config > fileSystems > edit public
            $path = $file->store('/covers', 'public');
            $request->merge([
                'cover_image_path' => $path,
            ]);
        }
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

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom created');
    }

    public function show(Classroom $classroom)
    {
        // Classroom ::where('id', '=', $id)->first(); same result
        // $classroom = Classroom::findOrFail($id);

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

        $img = $classroom->cover_image_path;

        if($request->hasFile('cover_image')){

            $imagePath = public_path('storage/'. $img);
            if(File::exists($imagePath)){
                File::delete($imagePath);
            }

            $file = $request->file('cover_image'); //Uploaded File
            $img = $file->store('/covers', 'public');
            $request->merge([
                'cover_image_path' => $img,
            ]);
        }
        // Mass assignment
        $classroom->update($request->all());
        // $classroom->fill($request->all())->save();



        // Same result (->with('success', 'Classroom updated'))
        Session::flash('success', 'Classroom updated');

        return Redirect::route('classrooms.index');
            // ->with('success', 'Classroom updated');
    }

    public function destroy($id)
    {
        $classroom = Classroom::find($id);
        $imagePath = public_path('storage/'. $classroom->cover_image_path);
        if(File::exists($imagePath)){
            File::delete($imagePath);
        }

        // Classroom::where('id', '=', $id)->delete(); // Same Result
        $count = Classroom::destroy($id);

        // $classroom->delete();

        return redirect(route('classrooms.index'))->with('success', 'Classroom deleted');
    }
}
