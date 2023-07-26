<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    //
    public function index(Request $request)
    {
        $topics = Topic::orderBy('id', 'DESC')->get();
        return view('topics.index', compact('topics'));
    }

    public function create(Request $request)
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $topic = new Topic();
        $topic->name = $request->post('name');
        $topic->classroom_id = 4;
        $topic->save();

        return redirect()->route('topics.index', 4);
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.show', compact('topic'));
    }

    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.edit', compact('topic'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $topic = Topic::findOrFail($id);

        $topic->update($request->all());

        return Redirect::route('topics.index', 4);
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->destroy($id);
        return redirect(route('topics.index', 4));
    }

    public function trashed()
    {
        $topics = Topic::onlyTrashed()
            ->latest('deleted_at')
            ->get();

        return view('topics.trashed', compact('topics'));
    }

    public function restore($id)
    {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()
            ->route('topics.index', 4)
            ->with('success', "Topic ({$topic->name}) restored");
    }

    public function forceDelete($id)
    {
        $topic = Topic::withTrashed()->findOrFail($id);
        $topic->forceDelete();


        return redirect()
            ->route('topics.index', 4)
            ->with('success', "Topic ({$topic->name}) deleted forever!");
    }
}
