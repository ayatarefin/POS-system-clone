<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;




class CreateAccountController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        $roles = DB::table('users_role')->get();
        return view('auth.index', compact('users'), ['roles' => $roles]);
    }
    public function create(Request $request)
    {
        $roles = DB::table('users_role')->get();
        return view('auth.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // Assuming only admins can create new user profiles
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }

        // Use Fortify's CreateNewUser class
        $creator = app(config('fortify.providers.users.model'));
        event(new Registered($user = $creator->create($request->all())));

        $this->guard->login($user);

        return app(RegisterResponse::class);
    }

}
