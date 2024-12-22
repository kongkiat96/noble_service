@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
        </ol>
    </nav>
    <hr>
    <div class="container-p-y">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-md-4 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">

                                @if ($dataEmployee->img_base == null)
                                    <img class="img-fluid rounded my-4" src="{{ asset('assets/img/img-not-found.png') }}"
                                        alt="Employee Image" height="200" width="200" />
                                @else
                                    <img class="img-fluid rounded my-4" src="{{ $dataEmployee->img_base }}"
                                        alt="Employee Image" height="200" width="200" />
                                @endif
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $dataEmployee->first_name . ' ' . $dataEmployee->last_name }}</h4>
                                    @if ($dataEmployee->user_class == 'SuperAdmin')
                                        <span class="badge bg-label-danger">ผู้ดูแลระบบ</span>
                                    @elseif($dataEmployee->user_class == 'Admin')
                                        <span class="badge bg-label-warning">เจ้าหน้าที่</span>
                                    @elseif($dataEmployee->user_class == 'user')
                                        <span class="badge bg-label-primary">ผู้บันทึกข้อมูล</span>
                                    @else
                                        <span class="badge bg-label-info">ผู้ใช้งานทั่วไป</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-2 border-bottom mb-4 mt-3">รายละเอียดข้อมูลส่วนตัว</h5>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-bold me-2">Status :</span>
                                    @if ($dataEmployee->status_login == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">บริษัท :</span>
                                    <span>{{ $aboutDepartment[0]->company_name_th }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">สังกัด / ฝ่าย :</span>
                                    <span>{{ $aboutDepartment[0]->departmentName }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-bold me-2">สาขา :</span>
                                    <span>{{ $dataEmployee->branch_name }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-3">
                                {{-- <a href="javascript:;" class="btn btn-secondary me-3" data-bs-target="#editUser"
                                    data-bs-toggle="modal">Edit</a> --}}
                                {{-- <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspended</a> --}}
                                @if(COUNT($checkAccessManaget) >= 1)
                                {{-- <a href="#" class="btn btn-warning me-3"><i class='menu-icon tf-icons bx bxs-user-check'></i>รายการอนุมัติงาน </a> --}}
                                <button type="button" class="btn btn-warning" id="btnApproveCaseSubManager">
                                    <i class='menu-icon tf-icons bx bxs-user-check'></i> รายการรออนุมัติงาน
                                    <span class="badge bg-white text-primary ms-1" id="caseApproveCount">{{ $countCaseApprove }}</span>
                                  </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-md-8 order-md-1">
                <div class="row">
                    <div class="col-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#open-case" aria-controls="#open-case"
                                        aria-selected="true">
                                        แจ้งปัญหาการใช้งาน
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-it" aria-controls="#service-it" aria-selected="true"
                                        id="reTabA">
                                        รายการแจ้งปัญหาฝ่ายไอที
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-mt" aria-controls="#service-mt" aria-selected="true"
                                        id="reTabB">
                                        รายการแจ้งปัญหาฝ่ายอาคาร
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-user-check" aria-controls="#service-user-check"
                                        aria-selected="true" id="reTabC">
                                        รายการตรวจสอบงานเสร็จสิ้น
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="open-case" role="tabpanel">
                                    @include('app.home.service.opencase')
                                </div>

                                <div class="tab-pane fade" id="service-it" role="tabpanel">
                                    <div class="text-nowrap table-responsive">
                                        @include('app.home.service.it.tableCaseAll')
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="service-mt" role="tabpanel">
                                    <div class="text-nowrap table-responsive">
                                        @include('app.home.service.mt.tableCaseAll')
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="service-user-check" role="tabpanel">

                                    <div class="text-nowrap table-responsive">
                                        <table class="dt-category-detail table table-hover table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                                    <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                                    <th>ข้อมูลอาการแจ้งซ่อม</th>
                                                    <th>สถานะการใช้งาน</th>
                                                    <th>วันที่บันทึกข้อมูล</th>
                                                    <th>ผู้บันทึกข้อมูล</th>
                                                    <th>วันที่แก้ไขข้อมูล</th>
                                                    <th>ผู้แก้ไขข้อมูล</th>
                                                    <th>กำหนดรายละเอียด</th>
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
            </div>
            <!--/ User Content -->
        </div>
    </div>
@endsection
