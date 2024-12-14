@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/employee/manager') }}">กำหนดรายการผู้บังคับบัญชา</a>
            </li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>

    

    <div class="modal fade" id="addSubManagerModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editSubManagerModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">ชื่อ - นามสกุลผู้บังคับบัญชา</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $getDataManager->full_name }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ผู้บังคับบัญชา</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bx-sitemap bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">บริษัท</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $getDataManager->company_name_th }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ผู้บังคับบัญชา</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bxs-business bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">แผนก</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $getDataManager->group_name }}</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ผู้บังคับบัญชา</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-spreadsheet bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#sub-manager" aria-controls="#sub-manager" aria-selected="true" id="reTabA">
                            ข้อมูลรายการผู้ใต้บังคับบัญชา
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="sub-manager" role="tabpanel">
                        <div class="inline-spacing text-end">
                            @if (Auth::user()->user_system != 'Viewer')
                                <button type="button" class="btn btn-info" id="addSubManager">
                                    <i class='menu-icon tf-icons bx bx-git-repo-forked'></i> เพิ่มข้อมูลรายการผู้บังคับบัญชา
                                </button>
                            @endif
                        </div>
                        <div class="text-nowrap table-responsive">
                            <table class="dt-sub-manager table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ลำดับ</th>
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
    <input type="text" id="managerID" name="managerID" value="{{ $managerID }}" hidden>
    <div class="col-12">
        <div class="row">
            <div class="col-4">
                <a href="{{ url('/employee/manager') }}" class="btn btn-danger"><i
                        class="bx bx-arrow-back"></i> ย้อนกลับ</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/assets/custom/employee/manager/manager.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
