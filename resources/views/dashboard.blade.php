@extends('layouts.app')
@section('content')
    @if (session('success'))
        <input type="hidden" value="{{ session('success') }}" id="successid">
    @elseif(session('error'))
        <input type="hidden" value="{{ session('error') }}" id="successid">
    @endif
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="body-wrapper">
            <div class="container-fluid">
                <!--  Row 1 -->
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-strech">
                        <div class="card w-100">
                            <div class="card-body">

                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h2 class="card-title fw-semibold">Product Sale Chart</h2>
                                    </div>
                                    <div>
                                        @php $items = DB::table('all_items')->get();@endphp
                                    </div>
                                </div>

                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="row col-md-12">
                                        <div class="col-md-3">
                                            <label>From Date</label>
                                            <input value="{{ date('Y-m-01') }}" type="date" name="datetime"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>To Date</label>
                                            <input id="actionPerform" value="{{ date('Y-m-d') }}" type="date"
                                                name="todatetime" class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Product Name</label>
                                            <select class="form-select" name="itemName" id="itemName">
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($items as $data)
                                                    <option value="{{ $data->item_name }}">{{ $data->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mt-4">
                                            <button class="btn btn-success" type="button"
                                                onclick="dailySaleChart()"><i class="ti-bar-chart"></i> Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h3 class="card-title fw-semibold">Recent Alerts</h3>
                            </div> --}}
                {{-- @php $alerts = App\Models\Alert::where('Status',1)->orderBy('SN','DESC')->take(5)->get();
                            @endphp
                            @foreach ($alerts as $alert)
                            <div class="alert alert-success text-center">{{$alert->Message}} at {{date('h:i
                                A',strtotime($alert->Datetime.'+6 hours'))}}</div>
                            @endforeach --}}
                {{-- </div>
                    </div>
                </div>
            </div> --}}

            </div>
        </div>
    </div>
@endsection
