<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use DB;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // custom login fortify
        Fortify::loginView(function () {
            $roles = DB::table('users_role')->get();
            return view('auth.login', ['roles' => $roles]);
        });

        // Custom Registration fortify
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $credentials = $request->only('email', 'password');
            $roles = DB::table('users')
                ->join('users_role', 'users.admin_role', '=', 'users_role.role_name')
                ->where('users_role.role_name', $request->input('role')) // 'role' is the name of the role field
                ->select('users.*', 'users_role.role_name')
                ->first();

            if (Auth::once($credentials)) {
                $user = Auth::user();

                if ($user->admin_key == '9y$10/KcQvrB8AI3avTA' && $roles && $user->admin_role == $roles->role_name) {
                    session()->flash('success', '200');
                    return $user; // Return the authenticated user
                } else {
                    Auth::logout(); // Log out if not an admin
                    session()->flash('error', '401');
                }
            } else {
                session()->flash('error', '401');
            }
            session()->flash('error', '401');
            return false; // Return null if authentication fails
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
