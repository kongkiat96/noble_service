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
    {{-- <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">รออนุมัติดำเนินงาน</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">34</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ข้อมูล ณ เดือน {{ $dateNow }}</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="bx bxs-purchase-tag bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">กำลังดำเนินงาน</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">333</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ข้อมูล ณ เดือน {{ $dateNow }}</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-info rounded p-2">
                                <i class="bx bx-layer bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">รอตรวจสอบงานจากผู้ใช้</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">12</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ข้อมูล ณ เดือน {{ $dateNow }}</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-sitemap bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">ดำเนินงานเสร็จสิ้นแล้ว</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">12</h4>
                            </div>
                            <figcaption class="blockquote-footer mb-0 text-muted mt-3">
                                <cite title="Source Title">ข้อมูล ณ เดือน {{ $dateNow }}</cite>
                            </figcaption>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="bx bx-sitemap bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr> --}}
    <div class="container-p-y">
        <div class="row">
            <div class="col-md-6 order-md-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="nav-align-top mb-4">
                                    <ul class="nav nav-pills mb-3" role="tablist">
        
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#case-openCase" aria-controls="#case-openCase" aria-selected="true"
                                                id="reTabA">
                                                รายการแจ้งปัญหาเข้ามาใหม่ <span class="badge bg-white text-primary ms-1" id="caseNewCountMT">0</span>
                                            </button>
                                        </li>
        
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#case-working" aria-controls="#case-working" aria-selected="true"
                                                id="reTabB">
                                                รายการแจ้งปัญหาอยู่ระหว่างดำเนินงาน <span class="badge bg-white text-primary ms-1" id="caseDoingCountMT">0</span>
                                            </button>
                                        </li>

                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#case-addprice" aria-controls="#case-addprice" aria-selected="true"
                                                id="reTabB">
                                                รายการรอบันทึกค่าใช้จ่าย <span class="badge bg-white text-primary ms-1" id="caseApproveCountFU">0</span>
                                            </button>
                                        </li>
        
                                        {{-- <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#service-user-check" aria-controls="#service-user-check"
                                                aria-selected="true" id="reTabC">
                                                รายการตรวจสอบงานเสร็จสิ้น
                                            </button>
                                        </li> --}}
                                    </ul>
        
                                    <div class="tab-content">
        
                                        <div class="tab-pane fade show active" id="case-openCase" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-case-openCase table table-hover table-striped">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>Ticket</th>
                                                            <th>ผู้แจ้งปัญหา</th>
                                                            <th>วัน / เวลาที่แจ้งปัญหา</th>
                                                            <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                                            <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                                            <th>ข้อมูลอาการแจ้งปัญหา</th>
                                                            <th>ผู้บันทึกข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
        
                                        <div class="tab-pane fade" id="case-working" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-case-working table table-hover table-striped">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>Ticket</th>
                                                            <th>สถานะดำเนินงาน</th>
                                                            <th>ผู้แจ้งปัญหา</th>
                                                            <th>วัน / เวลาที่แจ้งปัญหา</th>
                                                            <th>ข้อมูลรายการกลุ่มอุปกรณ์</th>
                                                            <th>ข้อมูลรายการประเภทหมวดหมู่</th>
                                                            <th>ข้อมูลอาการแจ้งปัญหา</th>
                                                            <th>ผู้บันทึกข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="case-addprice" role="tabpanel">
        
                                            <div class="text-nowrap table-responsive">
                                                <table class=" table table-hover table-striped">
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
                </div>
            </div>
            <div class="col-md-6 order-md-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="ticket-detail">
                                    ยังไม่ได้เลือกข้อมูล Ticket
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/assets/custom/caseService/mt/getCaseAll.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
