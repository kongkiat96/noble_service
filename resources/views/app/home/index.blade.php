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
    <div class="modal fade" id="checkWorkerModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-xl" role="document">

        </div>
    </div>
    <div class="container-p-y">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-md-4 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="col-md-12 text-center">
                                @if ($dataEmployee->img_base == null)
                                    <div class="svg-profile img-fluid rounded">
                                        {!! config('aboutEmployee.imageName') !!}
                                    </div>
                                @else
                                    <img class="img-fluid rounded my-4" src="{{ $dataEmployee->img_base }}"
                                        alt="Employee Image" height="200" width="200" />
                                @endif
                            </div>
                            <div class="col-md-12">
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
                                        <span class="badge bg-white text-primary ms-1" id="CountCaseITByuser">0</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-mt" aria-controls="#service-mt" aria-selected="true"
                                        id="reTabB">
                                        รายการแจ้งปัญหาฝ่ายช่าง
                                        <span class="badge bg-white text-primary ms-1" id="CountCaseMTByuser">0</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#service-user-check" aria-controls="#service-user-check"
                                        aria-selected="true" id="reTabC">
                                        รายการตรวจสอบงานเสร็จสิ้น <span class="badge bg-success text-white ms-1" id="caseCheckWorkByUserAllCount">0</span>
                                    </button>
                                </li>

                                {{-- <div class="ml-2"> --}}
                                    @if(COUNT($checkAccessManaget) >= 1)
                                    {{-- <a href="#" class="btn btn-warning me-3"><i class='menu-icon tf-icons bx bxs-user-check'></i>รายการอนุมัติงาน </a> --}}
                                    <button type="button" class="btn btn-warning btn-md" id="btnApproveCaseSubManager">
                                        รายการรออนุมัติงาน
                                        <span class="badge bg-white text-primary ms-1" id="caseApproveCount">0</span>
                                      </button>
                                    @endif
                                {{-- </div> --}}
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
                                        @include('app.home.service.userCheck.tableCaseCheckWork')
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
