<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Classwork;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use App\Models\ClassworkUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;

class SubmissionController extends Controller
{
    //
    public function store(Request $request, Classwork $classwork)
    {
        Gate::authorize('submissions.create', [$classwork]);

        $request->validate([
            'files' => 'required|array',
            'files.*' => ['file', new ForbiddenFile('text/x.php', 'application/x-msdownload', 'application/x-httpd-php')]
        ]);
        $assigned = $classwork->users()->where('id', Auth::id())->exists(); // true or false
        if (!$assigned) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $date = [];
            foreach ($request->file('files') as $file) {
                $data[] = [
                    'classwork_id' => $classwork->id,
                    'content' => $file->store("submissions/{$classwork->id}"),
                    'type' => 'file',
                ];
            }
            $user = Auth::user();
            $user->submissions::createMany($data);
            ClassworkUser::where([
                'user_id' => $user->id,
                'classwork_id' => $classwork->id,
            ])->update([
                "status" => 'submitted',
                'submitted_at' => now(),
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }


        return back()->with('success', 'Work submitted');
    }

    public function file(Submission $submission)
    {
        $user = Auth::user();
        // Check if the user is classroom teacher

        /*
        SELECT * FROM classroom_user
        WHERE user_id = ?
        AND role = teacher
        AND classroom_id IN (
            SELECT classroom_id
            FROM classworks
            WHERE id IN (
                SELECT classwork_id
                FROM submissions
                WHERE id = ?
            )
        )

        AND EXISTS (
            SELECT 1 FROM classworks WHERE classworks.classroom_id = classroom_user.classroom_id
            AND EXISTS (
                SELECT 1 FROM submissions WHERE submissions.classwork_id = classworks.id AND id = ?
            )
        )

        $collection = DB::select('', [$user->id, 'teacher], '$submission->id)
        */
        $isTeacher = $submission
            ->classwork
            ->classroom
            ->teachers()->where('id', $user->id)->exists();

        $isOwner = $submission->user_id == $user->id;
        if (!$isTeacher && !$isOwner) {
            abort(403);
        }

        return response()->file(storage_path('app/' . $submission->content));


    }
}
