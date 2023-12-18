@extends('layouts.app')
@section('content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../images/logos/logo.webp" width="150" height="auto" alt="BnB Logo" />
                                </a>
                                <form method="post" action="{{ route('users.store') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email:</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role:</label>
                                        <select name="role" class="form-select" required>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
