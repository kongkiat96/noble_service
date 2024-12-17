@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ url('#') }}">อนุมัติการแจ้งงาน</a>
            </li>
        </ol>
    </nav>
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
        
                                        {{-- <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#service-user-check" aria-controls="#service-user-check"
                                                aria-selected="true" id="reTabC">
                                                รายการตรวจสอบงานเสร็จสิ้น
                                            </button>
                                        </li> --}}
                                    </ul>
        
                                    <div class="tab-content">
        
                                        <div class="tab-pane fade show active" id="service-it" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-category-detail table table-hover table-striped">
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
        
                                        <div class="tab-pane fade" id="service-mt" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-category-detail table table-hover table-striped">
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
                </div>
            </div>
            <div class="col-md-6 order-md-0">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="nav-align-top mb-4">
                                    <ul class="nav nav-pills mb-3" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#detail-case" aria-controls="#detail-case"
                                                aria-selected="true">
                                                รายการแจ้งปัญหา
                                            </button>
                                        </li>
        
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#case-pic" aria-controls="#case-pic" aria-selected="true"
                                                id="reTabA">
                                                รูปภาพที่แจ้ง
                                            </button>
                                        </li>
        
                                    </ul>
        
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="detail-case" role="tabpanel">
                                            <div id="ticket-detail">
                                                ยังไม่ได้เลือกข้อมูล Ticket
                                            </div>
                                        </div>
        
                                        <div class="tab-pane fade" id="case-pic" role="tabpanel">
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
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
