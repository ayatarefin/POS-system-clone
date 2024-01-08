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
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }
    public function rules()
    {
        $roles = ['Admin', 'Analyst', 'Manager'];

        return [
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:5',
            'admin_key' => 'required', // Add this line if admin_key is required
            'role' => 'required|in:' . implode(',', $roles),
        ];
    }
}
