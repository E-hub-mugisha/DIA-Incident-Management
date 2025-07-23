<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Incident;
use App\Models\IncidentMitigation;
use App\Models\IncidentReviews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $incident = Incident::with('auditLogs.user', 'reviews.user')->findOrFail($id);
        return view('incidents.show', compact('incident'));
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
    public function assign(Request $request, Incident $incident)
    {
        $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:new,acknowledged'],
        ]);

        $incident->assigned_to = $request->assigned_to;
        $incident->status = $request->status;
        $incident->save();

        // Optional: Send notification to assigned user here

        return redirect()->route('incidents.unassigned')->with('success', 'Incident assigned successfully.');
    }

    public function incidentAssigned()
    {
        $incidents = Incident::whereNotNull('assigned_to')->get();
        return view('incidents.assigned', compact('incidents'));
    }
    public function unassigned()
    {
        $incidents = Incident::whereNull('assigned_to')->get();
        $users = User::whereIn('role', ['handler', 'admin'])->get(); // Only handlers/admins can be assigned
        return view('incidents.unassigned', compact('incidents', 'users'));
    }
    public function incidentReview(Request $request)
    {
        $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'media' => 'nullable|file|max:2048', // 2MB max
        ]);

        $mediaPath = null;

        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('incident_reviews', 'public');
        }

        IncidentReviews::create([
            'incident_id' => $request->incident_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media' => $mediaPath,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function storeNote(Request $request, Incident $incident)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        $note = $incident->dailyNotes()->create([
            'user_id' => Auth::id(),
            'note' => $request->note,
        ]);

        // Trigger audit log (see next step)
        $note->auditLogs()->create([
            'user_id' => Auth::id(),
            'event' => 'created',
            'old_values' => null,
            'new_values' => ['note' => $note->note],
            'auditable_type' => get_class($note),
            'auditable_id' => $note->id,
        ]);

        return redirect()->back()->with('success', 'Daily note added successfully.');
    }
    public function storeMitigation(Request $request, $incidentId)
    {
        $request->validate([
            'mitigation' => 'required|string',
        ]);

        $mitigation = IncidentMitigation::create([
            'incident_id' => $incidentId,
            'user_id' => Auth::id(),
            'mitigation' => $request->mitigation,
        ]);

        // Update the incident status to 'resolved'
        $incident = $mitigation->incident;
        $incident->status = 'resolved';
        $incident->save();

        return redirect()->back()->with('success', 'Mitigation added and incident marked as resolved.');
    }
}
