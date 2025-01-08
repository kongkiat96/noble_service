@extends('layouts.app')

@section('content')
    <div class="modal fade" id="addStatusModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editStatusModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="addFlagTypeModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editFlagTypeModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="addGroupStatusModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editGroupStatusModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#set-status" aria-controls="set-status" aria-selected="true" id="reTabA">
                            รายการชื่อสถานะ
                        </button>
                    </li>
                    {{-- <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#flag-type" aria-controls="flag-type" aria-selected="false" id="reTabB">
                            รายการรูปแบบสถานะ
                        </button>
                    </li> --}}

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#group-status" aria-controls="group-status" aria-selected="false" id="reTabC">
                            รายการกลุ่มสถานะ
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="set-status" role="tabpanel">
                        <div class="inline-spacing text-end">
                            <button type="button" class="btn btn-info" id="addStatus">
                                <i class='menu-icon tf-icons bx bxs-purchase-tag'></i> เพิ่มรายการสถานะ
                            </button>
                        </div>
                        <div class="text-nowrap">
                            <table class="dt-settingStatus table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รายการสถานะ</th>
                                        <th>การใช้งานสำหรับฝ่าย</th>
                                        <th>การแสดงผลสถานะ</th>
                                        <th>กลุ่มสถานะ</th>
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
                    {{-- <div class="tab-pane fade" id="flag-type" role="tabpanel">
                        <div class="inline-spacing text-end">

                            <button type="button" class="btn btn-info" id="addFlagType">
                                <i class='menu-icon tf-icons bx bxs-purchase-tag'></i> เพิ่มรายการรูปแบบสถานะ
                            </button>
                        </div>
                        <div class="text-nowrap">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รายการสถานะ</th>
                                        <th class="text-center">รูปแบบของสถานะ</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> --}}

                    <div class="tab-pane fade" id="group-status" role="tabpanel">
                        <div class="inline-spacing text-end">

                            <button type="button" class="btn btn-info" id="addGroupStatus">
                                <i class='menu-icon tf-icons bx bxs-purchase-tag'></i> เพิ่มกลุ่มรายการสถานะ
                            </button>
                        </div>
                        <div class="text-nowrap">
                            <table class="dt-settingGroupStatus table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>กลุ่มสถานะ (ภาษาไทย)</th>
                                        <th>กลุ่มสถานะ (ภาษาอังกฤษ)</th>
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
    <script type="text/javascript" src="{{ asset('/assets/custom/settings/status/status.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
