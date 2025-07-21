<?php

namespace App\Http\Controllers;

use App\Models\Mitigation;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {

        $mitigations = Mitigation::with(['risk', 'staff'])->get();

        $statusSummary = Mitigation::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $overdueCount = Mitigation::where('deadline', '<', now())
            ->where('status', '!=', 'Completed')
            ->count();

        return view('monitoring.index', compact('mitigations', 'statusSummary', 'overdueCount'));
    }
}
