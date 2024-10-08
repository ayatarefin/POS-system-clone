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
                                        @php $items = \App\Models\StockRecord::select('item_name')->groupBy('item_name')->get();@endphp
                                    </div>
                                </div>

                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="row col-md-12">
                                        <div class="col-md-3">
                                            <label for="fromDate">From Date:</label>
                                            <input value="{{ date('Y-m-01') }}" type="date" name="datetime" id="fromDate" class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <label for="toDate">To Date:</label>
                                            <input id="toDate" value="{{ date('Y-m-d') }}" type="date" name="todatetime" class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <label for="itemName">Product Name</label>
                                            <select class="form-select" name="itemName" id="itemName">
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($items as $data)
                                                    <option value="{{ $data->item_name }}">{{ $data->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mt-4">
                                            <button class="btn btn-success" type="button" id="generateChart"><i class="ti-bar-chart"></i>Generate Chart</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
