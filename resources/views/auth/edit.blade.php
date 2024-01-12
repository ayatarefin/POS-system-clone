@extends('layouts.app')

@section('content')
    <style>
        .small-card {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
<body>

    <div class="container mt-4">
        <div class="card mb-4 small-card">
            <div class="card-header">
                <h4>Edit User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input class="form-control" type="text" name="user_name" id="user_name" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" name="user_email" id="user_email" placeholder="Email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Set Password</label>
                        <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Set Password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success display-add-user">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
