@extends('layouts.app')

@section('stylesheets')
    <style>
        div.dt-buttons {
    float: left !important;
    margin-bottom: 10px; /* ปรับระยะห่าง */
}

    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">รายงาน : {{ $urlName }}</li>
        </ol>
    </nav>
    <hr>

    <input type="text" class="form-control" placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-range" hidden/>
    <form class="form-block">
        <div class="card">
            <div class="card-header">
                <h5>ค้นหารายงานแจ้งปัญหา</h5>
            <hr>

            </div>
            <div class="card-body">
                <div class="row g-3">
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label-md mb-2" for="dateRangePicker">ช่วงวันที่แจ้งปัญหา</label>
                        <div class="input-group input-daterange" id="bs-datepicker-daterange">
                          <input type="text" id="start_date" placeholder="YYYY-MM-DD" class="form-control" />
                          <span class="input-group-text">ถึง</span>
                          <input type="text" id="end_date" placeholder="YYYY-MM-DD" class="form-control" />
                        </div>
                      </div>


                    <div class="col-md-4">
                        <label class="form-label-md mb-2" for="case_status">สถานะดำเนินงาน</label>
                        <select id="case_status" name="case_status" class="form-select select2" autocomplete="off"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($statusWork as $key)
                                    {{-- @if (!in_array($key->ID, [99999])) --}}
                                    <option value="{{ $key->ID }}">{{ $key->status_name }}</option>
                                    {{-- @endif --}}
                                @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-md mb-2" for="status_ticket">สถานะ Ticket</label>
                        <select id="status_ticket" name="status_ticket" class="form-select select2" autocomplete="off"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="auto_close">ปิดงานอัตโนมัติ</option>
                            <option value="user_close">ปิดงานโดยผู้ใช้</option>
                            <option value="wait_close">รอปิดงาน</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label-md mb-2" for="category_main_id">รายการกลุ่มอุปกรณ์</label>
                        <select class="form-select select2 category_main_id_select" name="category_main_id" id="category_main_id" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryMain as $item)
                                <option value="{{ $item->id }}">{{ $item->category_main_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label-md mb-2" for="category_type_id">รายการประเภทหมวดหมู่</label>
                        <select class="form-select select2" name="category_type_id" id="category_type_id" data-allow-clear="true">
                            <option value="">Select</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label-md mb-2" for="category_detail">รายการอาการที่แจ้งปัญหา</label>
                        <select id="category_detail" name="category_detail" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                        </select>
                    </div>

                </div>
                <input type="text" value="{{ encrypt($reportType) }}" id="reportType" name="reportType" hidden>
                <div class="demo-inline-spacing text-center">
                    <button type="button" class="btn btn-label-info btn-form-block-overlay" id="searchDataForReport">
                        <span class="tf-icons bx bx-search me-1"></span>ค้นหาข้อมูล
                    </button>
                    <button type="button" class="btn btn-label-danger" id="resetSearchData">
                        <span class="tf-icons bx bx-reset me-1"></span>ล้างค่า
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h5>ผลลัพธ์การค้นหา</h5>
            </div>
            <div class="card-body">
                <div class="text-nowrap">
                    <table class="dt-search-datareport table table-hover">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>Ticket</th>
                                <th>สถานะ Ticket</th>
                                <th>วัน - เวลาที่แจ้งปัญหา</th>
                                <th>วัน - เวลาที่ SV อนุมัติแจ้งซ่อม</th>
                                <th>วัน - เวลาที่ MT Manager อนุมัติซ่อม</th>
                                <th>สาขา/Department ที่เปิด Ticket</th>
                                <th>รายการกลุ่มแจ้งปัญหา</th>
                                <th>รายการประเภทหมวดหมู่</th>
                                <th>รายการอาการแจ้งปัญหา</th>
                                <th>รายการที่เสีย</th>
                                <th>รายการที่แก้ไขปัญหา</th>
                                <th>กำหนดการแล้วเสร็จ (SLA)</th>
                                <th>ผล SLA (เกิน/ไม่เกิน)</th>
                                <th>วัน - เวลาที่ปิดงาน, Remark</th>
                                <th>ช่างผู้รับผิดชอบงาน</th>
                                <th>Supplier ที่รับผิดชอบ</th>
                                <th>ค่าใช้จ่ายในการซ่อม</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script src="{{ asset('/assets/custom/report/report.js?v=') }}@php echo date("H:i:s") @endphp"></script>
<script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
    <script>
        mapSelectedCategory('#category_type_id','.category_main_id_select',true)
        mapSelectedCategoryDetail('#category_detail', '#category_type_id', true)
    </script>
@endsection
