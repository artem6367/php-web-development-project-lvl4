<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $task = new Task();
        $statuses = TaskStatus::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        return view('tasks.create', compact('task', 'statuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id'
        ]);

        $task = new Task($data);
        $task->author()->associate(Auth::user());
        $task->save();
        return redirect()
            ->route('tasks.index')
            ->with('success', __('messages.task.success.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }
        $statuses = TaskStatus::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        return view('tasks.edit', compact('task', 'statuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id'
        ]);

        $task->fill($data);
        $task->save();
        return redirect()
            ->route('tasks.index')
            ->with('success', __('messages.task.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::guest() || $task->author->id != Auth::user()->id) {
            throw new AuthorizationException();
        }

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', __('messages.task.success.delete'));
    }
}
