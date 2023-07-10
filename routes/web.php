<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\TopicsController;

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

Route::get('/classrooms', [ClassroomsController::class, 'index'])->name('classrooms.index');

Route::get('/classrooms/{classroom}', [CLassroomsController::class, 'show'])->name('classrooms.show')->where('classroom', '\d+');

Route::get('/classrooms/create', [CLassroomsController::class, 'create'])->name('classrooms.create');

Route::post('/classrooms', [CLassroomsController::class, 'store'])->name('classrooms.store');

Route::get('/classrooms/{classroom}/edit', [ClassroomsController::class, 'edit'])->name('classrooms.edit')->whereNumber('id');

Route::put('/classrooms/{classroom}', [ClassroomsController::class, 'update'])->name('classrooms.update')->whereNumber('id');

Route::delete('/classrooms/{classroom}', [ClassroomsController::class, 'destroy'])->name('classrooms.destroy')->whereNumber('id');

Route::prefix('/topics')->name('topics.')->group(function(){
    Route::get('/', [TopicsController::class, 'index'])->name('index');
    Route::get('/create', [TopicsController::class, 'create'])->name('create');
    Route::post('/', [TopicsController::class, 'store'])->name('store');
    Route::get('/topics/{topic}', [TopicsController::class, 'show'])->name('show');
    Route::get('/topics/{topic}/edit', [TopicsController::class, 'edit'])->name('edit');
    Route::put('/topics/{topic}', [TopicsController::class, 'update'])->name('update');
    Route::delete('/topics/{topic}', [TopicsController::class, 'destroy'])->name('destroy');
});
