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
                                                data-bs-target="#approve-mt" aria-controls="#approve-mt" aria-selected="true"
                                                id="reTabA">
                                                รายการแจ้งปัญหากลุ่มอาคาร <span class="badge bg-white text-primary ms-1" id="caseApproveCountMT">0</span>
                                            </button>
                                        </li>
        
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#approve-fu" aria-controls="#approve-fu" aria-selected="true"
                                                id="reTabB">
                                                รายการแจ้งปัญหากลุ่มเฟอร์นิเจอร์ <span class="badge bg-white text-primary ms-1" id="caseApproveCountFU">0</span>
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
        
                                        <div class="tab-pane fade show active" id="approve-mt" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-approve-mt table table-hover table-striped">
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
        
                                        <div class="tab-pane fade" id="approve-fu" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-approve-fu table table-hover table-striped">
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
    <script type="text/javascript" src="{{ asset('/assets/custom/caseService/mt/approveCase.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
