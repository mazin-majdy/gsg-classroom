<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    //
    public function index(Request $request, Classroom $classroom)
    {
        $topics = Topic::orderBy('id', 'DESC')->get();
        return view('topics.index', compact('topics', 'classroom'));
    }

    public function create(Request $request, Classroom $classroom)
    {
        return view('topics.create', compact('classroom'));
    }

    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $topic = new Topic();
        $topic->name = $request->post('name');
        $topic->classroom_id = $classroom->id;
        $topic->save();

        return redirect()->route('topics.index', $classroom->id)->with('Topic created successfully');
    }

    public function show($id, Classroom $classroom)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.show', compact('topic', 'classroom'));
    }

    public function edit($id, Classroom $classroom)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.edit', compact('topic', 'classroom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $topic = Topic::findOrFail($id);

        $topic->update($request->all());

        return Redirect::route('topics.index', 37);
    }

    public function destroy($id, Classroom $classroom)
    {
        $topic = Topic::findOrFail($id);
        $topic->destroy($id);
        return redirect(route('topics.index', $classroom->id));
    }

    public function trashed(Classroom $classroom)
    {
        $topics = Topic::onlyTrashed()
            ->latest('deleted_at')
            ->get();

        return view('topics.trashed', compact('topics', 'classroom'));
    }

    public function restore($id, Classroom $classroom)
    {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()
            ->route('topics.index', $classroom->id)
            ->with('success', "Topic ({$topic->name}) restored");
    }

    public function forceDelete($id, Classroom $classroom)
    {
        $topic = Topic::withTrashed()->findOrFail($id);
        $topic->forceDelete();


        return redirect()
            ->route('topics.index', $classroom->id)
            ->with('success', "Topic ({$topic->name}) deleted forever!");
    }
}
