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
                    <h2 class="card-title fw-semibold mb-4 text-center">Alert Receivers</h2>
                    <div class="card mb-0">
                        <div class="card-body table-responsive p-4">

                            <div class="d-sm-flex align-items-center mb-9">
                                <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"> Add New
                                    Receiver </button>
                            </div>

                            <table class="table table-striped text-center">
                                <thead>
                                    <tr class="table-primary">
                                        <th width="5%">
                                            <label for=""> SL </label>
                                        </th>

                                        <th width="25%">
                                            <label for=""> Receiver Name </label>
                                        </th>

                                        <th width="15%">
                                            <label for=""> Phone Number </label>
                                        </th>
                                        <th width="15%">
                                            <label for=""> Outlet </label>
                                        </th>
                                        <th width="15%">
                                            <label for=""> Status </label>
                                        </th>
                                        <th width="25%">
                                            <label for=""> Action </label>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($receivers as $data)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->number}}</td>

                                        <td>{{$data->outlet==''?'N/A':$data->outlet}}</td>
                                        @if($data->status == 1)
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" checked
                                                    onclick="alertRecieverDisable({{$data->id}})" />
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        @else
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" onclick="alertRecieverEnable({{$data->id}})">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        @endif
                                        <td>
                                            <!-- <button type="button" class="btn btn-sm btn-primary" onclick="openReceiverEditModal({{$data->id}})"> Edit </button> -->
                                            <form action="{{url('/')}}/reciever-delete/{{$data->id}}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    onclick="return confirm('Are you sure to delete it ?')"> Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Modal for edit alert recipient -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLongTitle">Edit Alert Receiver</h4>
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
                            </div>
                            <!-- End: Modal for edit alert recipient -->


                            <!-- Modal for add alert recipient -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLongTitle"> Add Alert Receiver </h4>
                                            <button type="button" class="btn close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="addAlertReceiver">
                                            <div class="modal-body text-center">
                                                <select class="form-select mb-4" name="outlet" id="outlet" required>
                                                    @php $outlets = DB::table('outlets')->get(); @endphp
                                                    <option value="" selected disabled>Select Outlet</option>
                                                    @foreach($outlets as $data)
                                                    <option value="{{$data->outlet_name}}">{{$data->outlet_name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <input class="form-control mb-4" type="text" name="name"
                                                    placeholder="Name" required>
                                                <input class="form-control mb-4" type="text" name="number"
                                                    placeholder="Hotline Number" pattern="[0-9]+" title="Only numbers"
                                                    required>
                                                <select class="form-select mb-4" name="status" id="status" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning close-modal"
                                                    data-dismiss="modal">Cancel</button>
                                                <input type="submit" value="Save"
                                                    class="btn btn-success addreceiver-submit-btn" />
                                                <button class="btn btn-success display-add-receiver"
                                                    style="display:none">
                                                    <i class="fa fa-refresh fa-spin "></i>Loading
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End: Modal for add alert recipient -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
