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
                                            <button type="button" class="nav-link active" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#approve-it"
                                                aria-controls="#approve-it" aria-selected="true" id="reTabA">
                                                รออนุมัติดำเนินงาน <span class="badge bg-white text-primary ms-1"
                                                    id="caseApproveCountIT">0</span>
                                            </button>
                                        </li>

                                        {{-- <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#approve-cctv" aria-controls="#approve-cctv"
                                                aria-selected="true" id="reTabB">
                                                รายการแจ้งปัญหากลุ่มขอตรวจสอบ CCTV <span
                                                    class="badge bg-white text-primary ms-1"
                                                    id="caseApproveCountCCTV">0</span>
                                            </button>
                                        </li> --}}

                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#caseCheckWork" aria-controls="#caseCheckWork" aria-selected="true"
                                                id="reTabC">
                                                รออนุมัติงานเสร็จสิ้น <span class="badge bg-white text-primary ms-1"
                                                    id="caseCheckWorkCount">0</span>
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content">

                                        <div class="tab-pane fade show active" id="approve-it" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-approve-it table table-hover table-striped">
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

                                        <div class="tab-pane fade" id="approve-cctv" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-approve-cctv table table-hover table-striped">
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
                                        {{-- <div class="tab-pane fade" id="caseCheckWork" role="tabpanel">
                                            <div class="text-nowrap table-responsive">
                                                <table class="dt-caseCheckWork table table-hover table-striped">
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
                                        </div> --}}
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
    <script type="text/javascript"
        src="{{ asset('/assets/custom/caseService/it/approveCase.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
