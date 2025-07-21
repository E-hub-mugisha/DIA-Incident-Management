<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use App\Models\Risk;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     */
    public function index()
    {
        $staff = Staff::with('department')->latest()->get();
        $users = User::all();
        $departments = Department::all();
        return view('staff.index', compact('staff', 'departments', 'users'));
    }

    /**
     * Store a newly created staff in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department_id' => 'required|exists:departments,id',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
    }

    /**
     * Update the specified staff in storage.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department_id' => 'required|exists:departments,id',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified staff from storage.
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
