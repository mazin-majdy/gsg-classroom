<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ClassroomResource;

class ClassroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')){
            abort(403);
        }
        $classrooms = Classroom::with('user:id,name', 'topics')
            ->withCount('students as students')
            ->paginate();
        return ClassroomResource::collection($classrooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::guard('sanctum')->user()->tokenCan('classrooms.create')){
            abort(403);
        }
        // try {
        $request->validate([
            'name' => ['required'],
        ]);
        // } catch (Throwable $e) {
        //     return Response::json([
        //         'message' => $e->getMessage(),

        //     ], 422);
        // }

        $classroom = Classroom::create($request->all());

        return Response::json([
            'code' => 100,
            'message' => __('Classroom created'),
            'classroom' => $classroom,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        if(!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')){
            abort(403);
        }
        // return $classroom->load('user')->loadCount('students');
        $classroom->load('user')->loadCount('students');
        return new ClassroomResource($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        if(!Auth::guard('sanctum')->user()->tokenCan('classrooms.update')){
            abort(403);
        }
        $request->validate([
            'name' => ['sometimes', 'required', "unique:classrooms,name,$classroom->id"],
            'section' => ['sometimes', 'required'],
        ]);
        $classroom->update($request->all());
        return [
            'code' => 100,
            'message' => __('Classroom updated'),
            'classroom' => $classroom,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Auth::guard('sanctum')->user()->tokenCan('classrooms.delete')){
            abort(403, 'You cannot delete this classroom');
        }
        Classroom::destroy($id);
        return Response::json([], 204);
    }
}
