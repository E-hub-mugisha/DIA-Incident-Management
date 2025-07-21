<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mitigation;
use App\Models\Risk;
use App\Models\Staff;
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
        $mitigations = Mitigation::with('risk')->latest()->get();
        $risks = Risk::all();
        $staffs = Staff::all();
        return view('mitigations.index', compact('mitigations','risks','staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'strategy' => 'required|string',
            'staff_id' => 'required|exists:staff,id',
            'deadline' => 'required|date',
            'status' => 'required',
        ]);

        Mitigation::create($request->all());

        return redirect()->back()->with('success', 'Mitigation action added.');
    }

    public function update(Request $request, Mitigation $mitigation)
    {
        $request->validate([
            'strategy' => 'required|string',
            'staff_id' => 'required|staff,id',
            'deadline' => 'required|date',
            'status' => 'required',
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
