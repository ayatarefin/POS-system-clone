<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CreateAccountController extends Controller
{
    public function create()
    {
        return view('auth.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user', // Adjust the roles as needed
        ]);

        // Create a new user using the User model
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'admin_id' => auth()->user()->id,
        ]);

        // Save the user to the database
        $user->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Successfully Registered');
    }
}
