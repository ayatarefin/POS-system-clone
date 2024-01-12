<?php

// namespace App\Actions\Fortify;

// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rule;
// use Laravel\Fortify\Contracts\CreatesNewUsers;

// class CreateNewUser implements CreatesNewUsers
// {
//     use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
//     public function create(array $input): User
//     {
//         Validator::make($input, [
//             'name' => ['required', 'string', 'max:255'],
//             'email' => [
//                 'required',
//                 'string',
//                 'email',
//                 'max:255',
//                 Rule::unique(User::class),
//             ],
//             'password' => $this->passwordRules(),
//             'admin_key' => ['required', 'string'], // Add validation for admin_key
//             'admin_role' => ['required', 'string'], // Add validation for admin_role
//         ])->validate();

//         return User::create([
//             'name' => $input['name'],
//             'email' => $input['email'],
//             'password' => Hash::make($input['password']),
//             'admin_key' => $input['admin_key'], // Save admin_key
//             'admin_role' => $input['admin_role'], // Save admin_role
//         ]);
//     }
// }
