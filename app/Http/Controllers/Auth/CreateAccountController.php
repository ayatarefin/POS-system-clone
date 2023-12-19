<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class CreateAccountController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        $roles = DB::table('users_role')->get();
        return view('auth.index',compact('users'),['roles' => $roles]);
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|string|min:8',
        'role' => 'required|in:Admin,Analyst,Manager', // Adjust the roles as needed
        'admin_key' => 'required', // Add this line if admin_key is required
    ]);

    $user = new User([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'admin_key' => $request->input('admin_key'),
        'role' => $request->input('role'),
        // 'admin_id' => auth()->user()->id,
    ]);

    // if ($user->save()) {
    //     // Log success or additional information if needed
    //     \Log::info('User saved successfully');
    // } else {
        // Log an error if the save operation fails
    //     \Log::error('Failed to save user');
    // }

    return response()->json([
        'status' => 'success',
    ]);
}
}
