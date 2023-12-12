@extends('layouts.app')
@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  Main wrapper -->
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4 text-center">Stock Reports</h2>
                    <div class="card mb-0">
                        <div class="d-block table-responsive card-body p-4">
                            <h5 class="p-3">Search your current stock</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th width="20%">
                                            <label for="todate"> From Date </label>
                                        </th>
                                        <th width="20%">
                                            <label for="todate"> To Date </label>
                                        </th>
                                        <th width="20%">
                                            <label for="outlet"> Outlet Name</label>
                                        </th>
                                        <th width="20%">
                                            <label for="product"> Product Name</label>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="form-control-sm" type="date" value="{{date('Y-m-d')}}"
                                                name="datetime" required />
                                        </td>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <td>
                                            <input class="form-control-sm" type="date" value="{{date('Y-m-d')}}"
                                                name="todatetime" required />
                                        </td>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <td>
                                            <select style="width:80%" class="form-select-sm" name="outletName" id="outletName" required>
                                                <option value="" selected disabled>Select Outlet</option>
                                                <?php foreach ($outlets as $outlet) : ?>
                                                    <option value="<?= $outlet ?>"><?= $outlet ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select style="width:80%" class="form-select-sm" name="itemName" id="itemName">
                                                <option value="" selected disabled>Select Product</option>
                                                <?php foreach ($items as $item) : ?>
                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" type="button"
                                                onclick="searchCurrentStock()"><i class="ti ti-search"></i> Search
                                            </button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-3">
                    <div class="card mb-0">
                        <div class="card-body table-responsive p-4 text-center display-current-stock">
                            <!-- response data here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
