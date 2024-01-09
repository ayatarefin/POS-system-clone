<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function create(Request $request)
    {
        $users = User::get();
        $roles = DB::table('users_role')->get();
        return view('auth.create', compact('users', 'roles'));
    }
    public function store(Request $request)
{
    // Assuming only admins can create new user profiles
    $adminRole = 'admin';

    // Check if the logged-in user has the admin role
    if (auth()->user() && auth()->user()->admin_role === $adminRole) {
        $validatedData = $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:5',
            'admin_key' => 'required|in:9y$10/KcQvrB8AI3avTA',
            'admin_role' => 'required|in:' . $adminRole,
        ]);

        $users = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'admin_key' => $validatedData['admin_key'],
            'admin_role' => $adminRole,
        ]);

        return redirect()->back()->with('success', 'Successfully Registered');
    }

    return redirect()->back()->with('error', 'Unauthorized to create new user profiles');
}



    // public function rules()
    // {
    //     $roles = DB::table('users_role')->pluck('role_name')->toArray();

    //     return [
    //         'name' => 'required|string|min:5',
    //         'email' => 'required|email|unique:users|max:255',
    //         'password' => 'required|min:5',
    //         'admin_key' => 'required|in:9y$10/KcQvrB8AI3avTA',
    //         'admin_role' => 'required|in:' . implode(',', $roles),
    //     ];
    // }

}
