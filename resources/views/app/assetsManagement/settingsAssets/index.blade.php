@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>

    <div class="modal fade" id="addAssetTypeModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editAssetTypeModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="viewAssetTypeModal"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="addAssetTagModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editAssetTagModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="viewAssetTagModal"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#setting-assets-tag" aria-controls="#setting-assets-tag" aria-selected="true" id="reTabA">
                            ข้อมูลรายการกลุ่มสินทรัพย์
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#setting-assets" aria-controls="#setting-assets" aria-selected="true" id="reTabB">
                            รายการข้อมูลอุปกรณ์
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="setting-assets-tag" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addAssetsTag">
                                    <i class='menu-icon tf-icons bx bxs-purchase-tag'></i> เพิ่มข้อมูลรายการกลุ่มสินทรัพย์
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-assetsTag table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ข้อมูลรายการกลุ่มสินทรัพย์</th>
                                        <th>สถานะการใช้งาน</th>
                                        <th>วันที่บันทึกข้อมูล</th>
                                        <th>ผู้บันทึกข้อมูล</th>
                                        <th>วันที่แก้ไขข้อมูล</th>
                                        <th>ผู้แก้ไขข้อมูล</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="setting-assets" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addAssetsType">
                                    <i class='menu-icon tf-icons bx bx-layer'></i> เพิ่มข้อมูลรายการอุปกรณ์
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-assetsType table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รายการอุปกรณ์</th>
                                        <th>กลุ่มสินทรัพย์</th>
                                        <th>สถานะการใช้งาน</th>
                                        <th>วันที่บันทึกข้อมูล</th>
                                        <th>ผู้บันทึกข้อมูล</th>
                                        <th>วันที่แก้ไขข้อมูล</th>
                                        <th>ผู้แก้ไขข้อมูล</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/assets/custom/assetsManagement/settingsAsset/settings_asset.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
