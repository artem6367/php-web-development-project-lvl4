<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $label = new Label();
        return view('labels.create', compact('label'));
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
            'description' => 'nullable'
        ]);

        $label = new Label($data);
        $label->save();
        return redirect()
            ->route('labels.index')
            ->with('success', __('messages.label.success.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $label->fill($data);
        $label->save();
        return redirect()
            ->route('labels.index')
            ->with('success', __('messages.label.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if (Auth::guest()) {
            throw new AuthorizationException();
        }

        if ($label->tasks()->exists()) {
            return redirect()
                ->route('labels.index')
                ->with('error', __('messages.label.error.delete'));
        }

        $label->delete();

        return redirect()
            ->route('labels.index')
            ->with('success', __('messages.label.success.delete'));
    }
}
