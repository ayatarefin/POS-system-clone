@extends('layouts.app')
@section('content')

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  Main wrapper -->
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4 text-center">Users Table</h2>
                    <div class="card mb-0">
                        <div class="card-body table-responsive p-4">

                            <div class="d-sm-flex align-items-center mb-9">
                                <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
                            </div>
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr class="table-primary">
                                        <th width="5%">
                                            <label for=""> SL </label>
                                        </th>

                                        <th width="20%">
                                            <label for=""> User  </label>
                                        </th>
                                        </th>
                                        <th width="30%">
                                            <label for=""> Email </label>
                                        </th>
                                        <th width="20%">
                                            <label for=""> Status </label>
                                        </th>
                                        <th width="25%">
                                            <label for=""> Action </label>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($users as $data)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->admin_role}}</td>
                                        {{-- <td>
                                            <label class="switch">
                                                <input type="checkbox" checked
                                                    onclick="alertRecieverDisable({{$data->id}})" />
                                                <span class="slider"></span>
                                            </label>
                                        </td> --}}
                                        {{-- @else
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" onclick="alertRecieverEnable({{$data->id}})">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="openReceiverEditModal({{$data->id}})"> Edit </button>
                                            <form action="{{url('/')}}/reciever-delete/{{$data->id}}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    onclick="return confirm('Are you sure to delete it ?')"> Delete
                                                </button>
                                            </form>

                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Modal for edit alert recipient -->
                            {{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLongTitle">Edit Users Profile</h4>
                                            <button type="button" onclick="recModalClose()" class="btn close"
                                                id="closedModal" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="editAlertReceiver">
                                            <div class="modal-body text-center">
                                                <select class="form-select mb-4" name="outlet" id="rec-outlet" required>

                                                </select>
                                                <input class="form-control mb-4" type="text" id="rec-name" name="name"
                                                    placeholder="Name" required>
                                                <input type="hidden" id="rec-id-hidden" name="id">
                                                <input class="form-control mb-4" type="text" id="rec-number"
                                                    name="number" placeholder="Hotline Number" pattern="[0-9]+"
                                                    title="Only numbers" required>
                                                <select class="form-select mb-4" name="status" id="rec-status" required>

                                                </select>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" onclick="recModalClose()" id="closedModal"
                                                    class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                                <input type="submit" value="Save"
                                                    class="btn btn-success editreceiver-submit-btn" />
                                                <button class="btn btn-success display-edit-receiver"
                                                    style="display:none">
                                                    <i class="fa fa-refresh fa-spin "></i>Loading
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End: Modal for edit alert recipient -->


                            <!-- Modal for add User -->
                            {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title"> Add New User </h4>
                                            <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form id="addNewUser" action="{{ route('users.store') }}" method="post">
                                            @csrf
                                            <div class="modal-body text-center">
                                                <input class="form-control mb-4" type="text" name="name"
                                                    placeholder="Full Name" required>
                                                <input class="form-control mb-4" type="email" name="email"
                                                    placeholder="email" aria-describedby="emailHelp" required>
                                                <input class="form-control mb-4" type="password" name="password"
                                                    placeholder="Set Password" required>
                                                <input class="form-control mb-4" type="text" name="admin_key"
                                                    placeholder="Admin Key" required>
                                                <select class="form-select mb-4" name="role" placeholder="User Role" required>
                                                    @foreach ($roles as $row)
                                                    <option value="{{ $row->role_name }}">{{ $row->role_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success display-add-user">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End: Modal for add user -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
