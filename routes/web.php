<?php

use App\Http\Controllers\Admin\TwoFactorAuthenticationController;
use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TopicsController;
use App\Http\Middleware\ApplyUserPreferences;
use Illuminate\Support\Facades\Route;
use PhpParser\Builder\Class_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin/2fa', [TwoFactorAuthenticationController::class, 'create']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';

// Route::get('/classrooms', [ClassroomsController::class, 'index'])->name('classrooms.index');

// Route::get('/classrooms/{classroom}', [CLassroomsController::class, 'show'])->name('classrooms.show')->where('classroom', '\d+');

// Route::get('/classrooms/create', [CLassroomsController::class, 'create'])->name('classrooms.create');

// Route::post('/classrooms', [CLassroomsController::class, 'store'])->name('classrooms.store');

// Route::get('/classrooms/{classroom}/edit', [ClassroomsController::class, 'edit'])->name('classrooms.edit')->whereNumber('id');

// Route::put('/classrooms/{classroom}', [ClassroomsController::class, 'update'])->name('classrooms.update')->whereNumber('id');

// Route::delete('/classrooms/{classroom}', [ClassroomsController::class, 'destroy'])->name('classrooms.destroy')->whereNumber('id');


// Route::group([
//     'middleware' => ['auth'],
// ], function(){

// });

Route::middleware(['auth:admin,web'])->group(function () {

    Route::post('subscriptions', [SubmissionController::class, 'store'])->name('subscriptions.store');
    Route::post('payments', [PaymentsController::class, 'store'])->name('payments.store');


    Route::get('/payments/{subscription}/success', [PaymentsController::class, 'success'])->name('payments.success');
    Route::get('/payments/{subscription}/cancel', [PaymentsController::class, 'cancel'])->name('payments.cancel');

    Route::prefix('classrooms/trashed')
        ->name('classrooms.')
        ->group(function () {

            Route::get('/', [ClassroomsController::class, 'trashed'])->name('trashed');

            Route::put('/{classroom}', [ClassroomsController::class, 'restore'])->name('restore');

            Route::delete('/{classroom}', [ClassroomsController::class, 'forceDelete'])->name('force-delete');
        });


    Route::resource('classrooms', ClassroomsController::class);

    Route::get('/classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])->middleware('signed')
        ->name('classrooms.join');

    Route::post('/classrooms/{classroom}/join', [JoinClassroomController::class, 'store']);

    Route::resource('classrooms.classworks', ClassworkController::class);

    Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])->name('classrooms.people');
    Route::delete('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])->name('classrooms.people.destroy');


    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('classworks/{classwork}/submissions', [SubmissionController::class, 'store'])
        ->name('submissions.store');

    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])->name('submissions.file');
});



// Route::resource('/classrooms', ClassroomsController::class)->names([
//     // 'index' => 'classrooms/index',
//     // 'create' => 'classrooms/create'
// ], [
//     'middleware' => ['auth']
// ]);

Route::prefix('classrooms.topics')->middleware('auth')->name('topics.')->group(function () {
    Route::get('/', [TopicsController::class, 'index'])->name('index');
    Route::get('/create', [TopicsController::class, 'create'])->name('create');
    Route::post('/', [TopicsController::class, 'store'])->name('store');

    Route::prefix('/trashed')
        ->group(function () {

            Route::get('/', [TopicsController::class, 'trashed'])->name('trashed');

            Route::put('/{topic}', [TopicsController::class, 'restore'])->name('restore');

            Route::delete('/{topic}', [TopicsController::class, 'forceDelete'])->name('force-delete');
        });

    Route::get('/{topic}', [TopicsController::class, 'show'])->name('show');
    Route::get('/{topic}/edit', [TopicsController::class, 'edit'])->name('edit');
    Route::put('/{topic}', [TopicsController::class, 'update'])->name('update');
    Route::delete('/{topic}', [TopicsController::class, 'destroy'])->name('destroy');
});

Route::get('plans', [PlansController::class, 'index'])->name('plans');
