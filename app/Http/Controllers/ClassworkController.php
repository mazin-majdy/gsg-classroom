<?php

namespace App\Http\Controllers;

use Error;
use App\Models\Classroom;
use App\Models\Classwork;
use App\Enums\ClassworkType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\ClassworkCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

class ClassworkController extends Controller
{

    protected function getType(Request $request)
    {
        try {
            return ClassworkType::from($request->query('type'));
        } catch (Error $e) {
            return Classwork::TYPE_ASSIGNMENT;
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom)
    {

        $this->authorize('viewAny', [Classwork::class, $classroom]);


        $success = session('success');
        // $classworks = Classwork::where('classroom_id', '=', $classroom->id)->get();
        $classworks = $classroom->classworks()
            ->with('topic') //Eager load
            ->withCount([
                'users as assigned_count' => function ($query) {
                    $query->where('classwork_user.status', '=', 'assigned');
                },
                'users as turnedin_count' => function ($query) {
                    $query->where('classwork_user.status', '=', 'submitted');
                },
                'users as graded_count' => function ($query) {
                    $query->whereNotNull('classwork_user.grade');
                },

            ])
            ->filter($request->query())
            ->latest('published_at') // default DESC
            ->where(function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', '=', Auth::id());
                })
                    ->orWhereHas('classroom.teachers', function ($query) {
                        $query->where('id', '=', Auth::id());
                    });
            })
            // ->where(function ($query) {
            //     $query->whereRaw('EXISTS (SELECT 1 FROM classwork_user
            //     WHERE classwork_user.classwork_id = classworks.id
            //     AND classwork_user.user_id = ?
            //     )', Auth::id());

            //     $query->orWhereRaw('EXISTS (SELECT 1 FROM classroom_user WHERE classroom_user.classroom_id = classworks.classroom_id
            //     AND classroom_user.user_id = ?
            //     AND classroom_user.role = ?
            //     )', [Auth::id(), 'teacher']);
            // })

            ->paginate();
        // ->simplePaginate(5);


        return view('classworks.index', [
            'classroom' => $classroom,
            'classworks' => $classworks->groupBy('topic_id'),
            // 'classworks' => $classworks,
            'success' => $success
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {


        // if (!Gate::allows('classworks.create', [$classroom])) {
        //     abort(403);
        // }

        // $response = Gate::inspect('classworks.create', [$classroom]);
        // if(!$response->allowed()){
        //     abort(403, $response->message() ?? '');
        // }

        // Gate::authorize('classworks.create', [$classroom]);

        $this->authorize('create', [Classwork::class, $classroom]);

        $type = $this->getType($request)->value;
        $classwork = new Classwork();
        return view('classworks.create', compact('classroom', 'type', 'classwork'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {

        // if (Gate::denies('classworks.create', [$classroom])) {
        //     abort(403);
        // }

        $this->authorize('create', [Classwork::class, $classroom]);


        $type = $this->getType($request);
        // dd($request->all());
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at']
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type->value,
            // 'classroom_id' => $classroom->id
        ]);

        try {

            DB::transaction((function () use ($classroom, $request) {


                $classwork = $classroom->classworks()->create($request->all());
                // $classwork = Classwork::create($request->all());

                $classwork->users()->attach($request->input('students'));

                // event('classwork.created', [$classroom, $classwork]);
                // event(new ClassworkCreated($classwork));
                ClassworkCreated::dispatch($classwork);
            }));
        } catch (QueryException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('classrooms.classworks.index', $classroom->id)
            ->with('success', __('Classwork created!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        // Gate::authorize('classworks.view', [$classwork]);

        $this->authorize('view', $classwork);

        $submissions = Auth::user()
            ->submissions()
            ->where('classwork_id', $classwork->id)
            ->get();

        return view('classworks.show', compact('classroom', 'classwork', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('update', $classwork);

        $type = $classwork->type->value;
        $assigned = $classwork->users()->pluck('id')->toArray();

        return view('classworks.edit', compact('classroom', 'type', 'assigned', 'classwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('update', $classwork);

        $type = $classwork->type;
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at']
        ]);
        //
        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));
        // sync بتحدف الكل من الجدول الوسيط وبترجع تعبي المحددين

        return redirect()->route('classrooms.classworks.index', $classroom->id)
            ->with('success', __('Classwork updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('delete', $classwork);
    }
}
