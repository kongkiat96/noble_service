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



    <div class="modal fade" id="addManagerModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editManagerModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#manager" aria-controls="#manager" aria-selected="true" id="reTabA">
                            ข้อมูลรายการผู้บังคับบัญชา
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#search-manager" aria-controls="#search-manager" aria-selected="true"
                            id="reTabB">
                            ค้นหาข้อมูลผู้บังคับบัญชา / ผู้ใต้บังคับบัญชา
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="manager" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addManager">
                                    <i class='menu-icon tf-icons bx bx-git-repo-forked'></i> เพิ่มข้อมูลรายการผู้บังคับบัญชา
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-manager table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อ - นามสกุลผู้บังคับบัญชา</th>
                                        <th>บริษัท</th>
                                        <th>ระดับตำแหน่ง</th>
                                        <th>ตำแหน่ง</th>
                                        <th>สังกัด / ฝ่าย</th>
                                        <th>แผนก</th>
                                        <th>ชื่อสาขา</th>
                                        <th>ชื่อสาขาย่อ</th>
                                        <th>จำนวนผู้ใต้บังคับบัญชา</th>
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
                    <div class="tab-pane fade" id="search-manager" role="tabpanel">
                        <form class="form-block">
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <label class="form-label-md mb-2" for="manager_id">ผู้บังคับบัญชา</label>
                                    <select id="manager_id" name="manager_id" class="form-select select2"
                                        data-allow-clear="true">
                                        <option value="">Select</option>
                                        @foreach ($dataManager as $key => $value)
                                            <option value="{{ $value->ID }}">{{ $value->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label-md mb-2" for="sub_emp_id">ผู้ใต้บังคับบัญชา</label>
                                    <select id="sub_emp_id" name="sub_emp_id" class="form-select select2"
                                        data-allow-clear="true">
                                        <option value="">Select</option>
                                        @foreach ($dataSubManager as $key => $value)
                                            <option value="{{ $value->ID }}">{{ $value->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="demo-inline-spacing text-center">
                                <button type="button" class="btn btn-label-info btn-form-block-overlay" id="searchDataManager">
                                    <span class="tf-icons bx bx-search me-1"></span>ค้นหาข้อมูล
                                </button>
                                <button type="button" class="btn btn-label-danger btn-form-block-overlay" id="resetSearchManager">
                                    <span class="tf-icons bx bx-reset me-1"></span>ล้างค่า
                                </button>
                            </div>
                            <hr>
                            <div class="text-nowrap table-responsive">

                                <table class="dt-search-manager table table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ - นามสกุลผู้บังคับบัญชา</th>
                                            <th>ชื่อ - นามสกุลผู้ใต้บังคับบัญชา</th>
                                            <th>บริษัท</th>
                                            <th>ระดับตำแหน่ง</th>
                                            <th>ตำแหน่ง</th>
                                            <th>สังกัด / ฝ่าย</th>
                                            <th>แผนก</th>
                                            <th>ชื่อสาขา</th>
                                            <th>ชื่อสาขาย่อ</th>
                                            <th>สถานะการใช้งาน</th>
                                            <th>วันที่บันทึกข้อมูล</th>
                                            <th>ผู้บันทึกข้อมูล</th>
                                            <th>วันที่แก้ไขข้อมูล</th>
                                            <th>ผู้แก้ไขข้อมูล</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript"
        src="{{ asset('/assets/custom/employee/manager/manager.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
