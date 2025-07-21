<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::with('category')->latest()->get();
        $categories = Category::all();
        $users = User::all();
        return view('incidents.index', compact('incidents', 'categories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'reported_by' => 'required',
            'assigned_to' => 'nullable',
            'category_id' => 'nullable',
            'severity' => 'required',
            'status' => 'nullable',
            'location' => 'nullable',
        ]);

        $incident = new Incident($validated);
        $incident->save();

        return redirect()->back()->with('success', 'Incident created successfully.');
    }

    public function show(Incident $incident)
    {
        return response()->json($incident->load('assignedTo', 'reportedBy', 'category'));
    }

    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'reported_by' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'nullable|in:new,acknowledged,in_progress,resolved',
            'location' => 'nullable|string|max:255',
        ]);

        $incident->fill($validated);
        $incident->save();

        return redirect()->back()->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();
        return redirect()->back()->with('success', 'Incident deleted successfully.');
    }
    public function assign(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $incident = Incident::findOrFail($id);
        $incident->assigned_to = $request->assigned_to;
        $incident->save();

        return redirect()->back()->with('success', 'Incident assigned successfully.');
    }

    public function incidentAssigned()
    {
        $incidents = Incident::whereNotNull('assigned_to')->get();
        return view('incidents.assigned', compact('incidents'));
    }
}
