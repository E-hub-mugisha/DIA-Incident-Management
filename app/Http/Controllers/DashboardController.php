<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\IncidentMitigation;
use App\Models\Incident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalIncidents = Incident::count();
        $totalMitigations = IncidentMitigation::count();
        $totalDepartments = Department::count();

        // Pie chart: IncidentMitigation status breakdown
        $statusSummary = Incident::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Line chart: Monthly IncidentMitigation trends (this year)
        $months = IncidentMitigation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Fill in missing months (1-12)
        $monthLabels = [];
        $monthValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthLabels[] = Carbon::create()->month($i)->format('M');
            $monthValues[] = $months[$i] ?? 0;
        }
        $monthlyData = array_combine($monthLabels, $monthValues);

        // Latest 5 Incidents
        $mitigations = IncidentMitigation::with([ 'incident'])
            ->latest()
            ->take(5)
            ->get();

        // Active Incidents without mitigation
        $IncidentsWithoutMitigation = Incident::doesntHave('mitigations')
            ->where('status', 'new')
            ->with('category')
            ->get();

            $users = User::all();
            $incidents = Incident::all();
        return view('dashboard.admin', compact(
            'totalUsers',
            'totalIncidents',
            'totalMitigations',
            'totalDepartments',
            'statusSummary',
            'mitigations',
            'months',
            'monthlyData',
            'IncidentsWithoutMitigation',
            'users',
            'incidents'
        ));
    }

    
}
