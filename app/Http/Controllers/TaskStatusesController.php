<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::paginate();
        return view('statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }
        $status = new TaskStatus();
        return view('statuses.create', compact('status'));
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
            'name' => 'required'
        ]);

        $status = new TaskStatus($data);
        $status->save();
        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('messages.status.success.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $task_status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $task_status)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }
        return view('statuses.edit', compact('task_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $task_status)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $data = $this->validate($request, [
            'name' => 'required'
        ]);

        $task_status->fill($data);
        $task_status->save();
        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('messages.status.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        if ($taskStatus->tasks()->exists()) {
            return redirect()
                ->route('task_statuses.index')
                ->with('error', __('messages.status.error.delete'));
        }

        $taskStatus->delete();

        return redirect()
            ->route('task_statuses.index')
            ->with('success', __('messages.status.success.delete'));
    }
}
