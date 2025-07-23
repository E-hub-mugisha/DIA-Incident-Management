<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentMitigation;
use App\Models\Mitigation;
use App\Models\user;
use Illuminate\Http\Request;

class MitigationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mitigations = IncidentMitigation::with('incident')->latest()->get();
        $incidents = Incident::all();
        $users = User::all();
        return view('mitigations.index', compact('mitigations','incidents','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'mitigation' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $mitigation = IncidentMitigation::create([
            'incident_id' => $request->incident_id,
            'user_id' => $request->user_id,
            'mitigation' => $request->mitigation,
        ]);

        // Update the incident status to 'resolved'
        $incident = $mitigation->incident;
        $incident->status = 'resolved';
        $incident->save();

        return redirect()->back()->with('success', 'Mitigation action added.');
    }

    public function update(Request $request, Mitigation $mitigation)
    {
        $request->validate([
            'mitigation' => 'required|string',
            'user_id' => 'required|users,id',
        ]);

        $mitigation->update($request->all());

        return redirect()->back()->with('success', 'Mitigation action updated.');
    }

    public function destroy(Mitigation $mitigation)
    {
        $mitigation->delete();
        return redirect()->back()->with('success', 'Mitigation action deleted.');
    }
}
