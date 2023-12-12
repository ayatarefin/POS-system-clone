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
                    <h2 class="card-title fw-semibold mb-4 text-center">Alert Configuration</h2>
                    <div class="card mb-0">
                        <div class="card-body p-4 table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr class="table-primary">
                                        <th width="5%">
                                            SL
                                        </th>
                                        <th width="25%">
                                            Item Name
                                        </th>
                                        <th width="20%">
                                            CutOff Time
                                        </th>
                                        <th width="20%">
                                            CutOff Limit
                                        </th>
                                        <th width="15%">
                                            Status
                                        </th>
                                        {{-- <th width="15%">
                                            Action
                                        </th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                    $count=1;
                                    @endphp
                                    @foreach($items as $item)
                                    <tr>
                                        <td>
                                            {{$count++}}
                                        </td>
                                        <td>
                                            {{$item->item_name}}
                                        </td>
                                        <td>
                                            <input type="time" value="{{$item->time}}" id="cutoff_time{{$item->SN}}">
                                        </td>
                                        <td>
                                            <input type="number" value="{{$item->qty}}" id="cutoff_qty{{$item->SN}}">
                                        </td>
                                        {{-- <td>
                                            @if($item->msg_delivery_status ==1)
                                            <label class="switch">
                                                <input type="checkbox" checked id="checkBoxInput{{$item->SN}}">
                                                <span class="slider"></span>
                                            </label>
                                            @else
                                            <label class="switch">
                                                <input type="checkbox" id="checkBoxInput{{$item->SN}}">
                                                <span class="slider"></span>
                                            </label>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <button class="btn btn-success"
                                                onclick="manageAlertMessage({{$item->SN}})">Update</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
