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

    

    <div class="modal fade" id="addCaseCCTVModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="addCasePermissionModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editCaseApproveModal" data-bs-backdrop="static" >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#caseCCTV" aria-controls="#caseCCTV" aria-selected="true" id="reTabA">
                            ข้อมูลรายการแจ้งขอตรวจสอบ CCTV
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#casePermission" aria-controls="#casePermission" aria-selected="true" id="reTabB">
                            ข้อมูลรายการแจ้งขอสิทธิ์ใช้งาน
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="caseCCTV" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addCaseCCTV">
                                    <i class='menu-icon tf-icons bx bx-cctv'></i> เพิ่มข้อมูลรายการแจ้งขอตรวจสอบ CCTV
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-case-approve-cctv table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รายการกลุ่มอุปกรณ์</th>
                                        <th>รายการประเภทหมวดหมู่</th>
                                        <th>อาการที่ต้องการแจ้งปัญหา</th>
                                        <th>ประเภทใช้งาน</th>
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

                    <div class="tab-pane fade" id="casePermission" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addCasePermission">
                                    <i class='menu-icon tf-icons bx bx-key'></i> เพิ่มข้อมูลรายการแจ้งขอสิทธิ์ใช้งาน
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-case-approve-permission table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รายการกลุ่มอุปกรณ์</th>
                                        <th>รายการประเภทหมวดหมู่</th>
                                        <th>อาการที่ต้องการแจ้งปัญหา</th>
                                        <th>ประเภทใช้งาน</th>
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
    <script type="text/javascript" src="{{ asset('/assets/custom/settings/caseApproveSpecial/caseApproveSpecial.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
