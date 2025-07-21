<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function index()
    {
        $risks = Risk::with('department', 'category')->latest()->get();
        $departments = Department::all();
        $categories = Category::all();
        return view('risks.index', compact('risks', 'departments', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'category_id' => 'required|exists:categories,id',
            'likelihood' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Low,Medium,High',
            'status' => 'nullable|in:Pending,In Progress,Mitigated,Escalated',
        ]);

        $risk = new Risk($validated);
        $risk->level = $risk->calculateRiskLevel(); // auto set risk level
        $risk->save();

        return redirect()->back()->with('success', 'Risk added with level: ' . $risk->level);
    }

    public function show(Risk $risk)
    {
        return response()->json($risk->load('department', 'category'));
    }

    public function update(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'category_id' => 'required|exists:categories,id',
            'likelihood' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Low,Medium,High',
            'status' => 'nullable|in:Pending,In Progress,Mitigated,Escalated',
        ]);

        $risk->fill($validated);
        $risk->level = $risk->calculateRiskLevel(); // recalculate level
        $risk->save();

        return redirect()->back()->with('success', 'Risk updated with level: ' . $risk->level);
    }

    public function destroy(Risk $risk)
    {
        $risk->delete();
        return redirect()->back()->with('success', 'Risk deleted successfully.');
    }
}
