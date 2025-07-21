<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Mitigation;
use App\Models\Risk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRisks = Risk::count();
        $totalMitigations = Mitigation::count();
        $totalDepartments = Department::count();

        // Pie chart: Mitigation status breakdown
        $statusSummary = Mitigation::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Line chart: Monthly mitigation trends (this year)
        $months = Mitigation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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

        // Latest 5 risks
        $recentRisks = Risk::with(['department', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Active risks without mitigation
        $risksWithoutMitigation = Risk::doesntHave('mitigations')
            ->where('status', 'active')
            ->with('department')
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalRisks',
            'totalMitigations',
            'totalDepartments',
            'statusSummary',
            'recentRisks',
            'months',
            'monthlyData',
            'risksWithoutMitigation'
        ));
    }

    
}
