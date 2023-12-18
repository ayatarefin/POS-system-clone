@extends('layouts.app')
@section('content')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="../images/logos/logo.webp" width="150" height="auto" alt="BnB Logo" />
                            </a>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                {{-- <div class="mb-3 text-center display-error">
                                    @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                    @endif

                                    @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif

                                </div> --}}
                                <div class="mb-3 text-center display-error">
                                    @if(session('success'))
                                    <input type="hidden" value="{{session('success')}}" id="successid">
                                    @elseif(session('error'))
                                    <input type="hidden" value="{{session('error')}}" id="successid">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail"
                                        aria-describedby="emailHelp" required>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        id="exampleInputPassword" required>
                                </div>
                                <div class="mb-4">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control" name="role" placeholder="Role" required>
                                        @foreach ($roles as $row)
                                            <option value="{{ $row->role_name }}">{{ $row->role_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value=""
                                            id="flexCheckChecked">
                                        <label class="form-check-label text-dark" for="flexCheckChecked">Remeber this
                                            Device</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                    In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
