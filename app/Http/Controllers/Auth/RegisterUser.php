<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use DB;

class RegisterUser extends Controller
{
    public function index()
    {
        $users = User::get();
        // $roles = DB::table('users_role')->get();
        return view('auth.index', compact('users'));
    }
    public function create()
    {
        // $roles = DB::table('users_role')->get();
        return view('auth.create');
    }
    public function store(Request $request)
    {
        // Validate request data

        $user = User::create([
            'name' => $request->input('user_name'),
            'email' => $request->input('user_email'),
            'password' => Hash::make($request->input('user_password')),
            'admin_key' => $request->input('admin_key'),
            'admin_role' => $request->input('admin_role'),
        ]);

        // Assign a role to the user
        $role = UserRole::where('role_name', $request->input('admin_role'))->first();
        $user->role()->associate($role);
        $user->save();

        return redirect('users')->with(['success', 'User Created Successfully']);
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = UserRole::get();
        return view('auth.edit', compact('user', 'roles'));
    }
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Retrieve the user model
        $user = User::find($id);

        if (!$user) {
            abort(404, 'User not found');
        }

        // Update user attributes
        $user->name = $request->input('user_name');
        $user->email = $request->input('user_email');

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('user_password'));
        }

        // Save the updated user
        if ($user->save()) {
            return redirect()->route('users')->with('success', 'User Information Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Oops, something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_delete = User::where('id', $user_id)->delete();
        if ($user_delete) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
