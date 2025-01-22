@extends('layouts.app')

@section('content')
    <div class="modal fade" id="addTokenModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <div class="modal fade" id="editTokenModal" data-bs-backdrop="static"  >
        <div class="modal-dialog modal-lg" role="document">

        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/home') }}">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">{{ $urlName }}</li>
        </ol>
    </nav>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#set-notify-telegram" aria-controls="set-notify-telegram" aria-selected="true" id="reTabA">
                            กำหนดการแจ้งเตือนผ่าน Telegram
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="set-notify-telegram" role="tabpanel">
                        <div class="inline-spacing text-end">
                            <button type="button" class="btn btn-info" id="addToken">
                                <i class='menu-icon tf-icons bx bxl-telegram'></i> เพิ่มรายการสถานะ
                            </button>
                        </div>
                        <div class="text-nowrap">
                            <table class="dt-setting-notify-telegram table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>Token</th>
                                        <th>Chat ID</th>
                                        <th>ฝ่ายที่ใช้งาน</th>
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
    <script type="text/javascript" src="{{ asset('/assets/custom/settings/notify/setnotify_telegram.js?v=') }}@php echo date("H:i:s") @endphp"></script>
@endsection
