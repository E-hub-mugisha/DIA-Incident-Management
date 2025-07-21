<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'], // only letters and spaces
            'email' => ['required'],
            'role' => ['required'], // assuming roles are 'admin' and 'user'
            'password' => [
                'required'
                ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ( Auth::user()->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
