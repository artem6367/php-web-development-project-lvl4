<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(['status_id', 'created_by_id', 'assigned_to_id'])
            ->paginate();

        $statuses = TaskStatus::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        $filter = array_merge(
            ['status_id' => null, 'created_by_id' => null, 'assigned_to_id' => null],
            $request->get('filter', [])
        );
        return view('tasks.index', compact('tasks', 'statuses', 'users', 'filter'));
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
        $labels = Label::all()->pluck('name', 'id');
        $labelValues = [];
        return view('tasks.create', compact('task', 'statuses', 'users', 'labels', 'labelValues'));
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
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array|exists:labels,id'
        ]);

        $task = new Task($data);
        $task->author()->associate(Auth::user());
        $task->save();
        if (array_key_exists('labels', $data)) {
            $saveLabels = Label::whereIn('id', $data['labels'])->get();
            $task->labels()->saveMany($saveLabels);
        }
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
        $labels = Label::all()->pluck('name', 'id');
        $labelValues = $task->labels()->get()->pluck('id')->all();
        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels', 'labelValues'));
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
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array|exists:labels,id'
        ]);

        $task->fill($data);
        $task->save();
        if (array_key_exists('labels', $data)) {
            $currentLabels = $task->labels()->get()->pluck('id')->all();
            $newLabels = Label::whereIn('id', $data['labels'])->whereNotIn('id', $currentLabels)->get();
            $deleteLabels = Label::whereIn('id', $currentLabels)->whereNotIn('id', $data['labels'])->get();
            $task->labels()->saveMany($newLabels);
            $task->labels()->detach($deleteLabels);
        } else {
            $task->labels()->detach();
        }
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
