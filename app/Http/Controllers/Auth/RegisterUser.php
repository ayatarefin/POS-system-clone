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
        $roles = UserRole::get();
        return view('auth.index', compact('users'));
    }
    public function create()
    {
        $roles = UserRole::get();
        return view('auth.create',compact('roles'));
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
        $user = User::where('id',$id)->first();
        $roles = UserRole::get();
        return view('auth.edit', compact('user', 'roles'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_name' => 'required|min:3|max:50',
            'user_email' => 'required|email|unique:users,email,' . $id,
            'user_password' => 'nullable|min:6|confirmed',
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
        if ($request->filled('user_password')) {
            $user->password = Hash::make($request->input('user_password'));
        }

        // Save the updated user
        if ($user->save()) {
            return redirect()->route('users.index')->with('success', 'User Information Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Oops, something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'User not found');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

}
