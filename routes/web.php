<?php

use App\Http\Controllers\LabelsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TaskStatusesController;
use Illuminate\Support\Facades\Route;

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

Route::resource('task_statuses', TaskStatusesController::class);

Route::resource('tasks', TasksController::class);

Route::resource('labels', LabelsController::class);

require __DIR__.'/auth.php';
