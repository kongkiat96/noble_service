<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-pic"
                aria-controls="#detail-pic" aria-selected="true">
                รูปภาพการแจ้งปัญหา
            </button>
        </li>

    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="detail-case" role="tabpanel">
            <div class="row g-1 form-block">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="ticket">Ticket</label>
                        <input type="text" id="ticket" class="form-control" name="ticket"
                            value="{{ $data['ticket'] }}" readonly autofocus>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_main_name">รายการกลุ่มอุปกรณ์</label>
                        <input type="text" id="category_main_name" class="form-control" name="category_main_name"
                            value="{{ $data['category_main_name'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_type_name">รายการประเภทหมวดหมู่</label>
                        <input type="text" id="category_type_name" class="form-control" name="category_type_name"
                            value="{{ $data['category_type_name'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_detail_name">อาการที่ต้องการแจ้งปัญหา</label>
                        <input type="text" id="category_detail_name" class="form-control" name="category_detail_name"
                            value="{{ $data['category_detail_name'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="asset_number">หมายเลขครุภัณฑ์</label>
                        <input type="text" id="asset_number" class="form-control" name="asset_number"
                            value="{{ $data['asset_number'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="employee_other_case_name">ผู้แจ้งปัญหา</label>
                        <input type="text" id="employee_other_case_name" class="form-control"
                            name="employee_other_case_name" value="{{ $data['employee_other_case_name'] }}" readonly>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_detail">รายละเอียด</label>
                        <textarea id="case_detail" name="case_detail" rows="3" class="form-control" readonly>{{ $data['case_detail'] }}</textarea>
                    </div>
                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">บันทึกสถานะการอนุมัติงาน</div>
                    </div>
                </div>
                <form id="formApproveManager">
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_status">สถานะการอนุมัติงาน</label>
                        {{-- <select name="case_status" id="case_status" class="form-select select2" data-allow-clear="true">
                            <option value=""></option>
                            <option value="manager_approve">อนุมัติดำเนินการแจ้งซ่อม</option>
                            <option value="reject_manager_approve">ไม่อนุมัติดำเนินการแจ้งซ่อม</option>
                        </select> --}}
                        <div class="row m-2">
                            <div class="col-md-6">
                                <div class="form-check form-check-success form-check-inline">
                                    <input name="case_status" class="form-check-input" type="radio" value="manager_approve" id="m_approve" />
                                    <label class="form-check-label" for="m_approve"> อนุมัติดำเนินการ </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-danger form-check-inline">
                                    <input name="case_status" class="form-check-input" type="radio" value="reject_manager_approve" id="m_reject" />
                                    <label class="form-check-label" for="m_reject"> ไม่อนุมัติดำเนินการ </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_approve_detail">รายละเอียดการอนุมัติงาน</label>
                        <textarea id="case_approve_detail" name="case_approve_detail" rows="3" class="form-control"></textarea>
                    </div>
                    <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>
                </form>
                <hr class="mt-4">
                <div class="col-12 text-center">
                    {{-- <button type="button" class="btn btn-label-danger"><i
                            class='menu-icon tf-icons bx bx-reset' id="resetFormApproveManager"></i>
                        ล้างฟอร์ม</button> --}}

                    <button type="submit" name="approveCaseManager" id="approveCaseManager"
                        class="btn btn-warning btn-form-block-overlay"><i
                            class='menu-icon tf-icons bx bxs-paper-plane'></i>
                        บันทึกข้อมูล</button>
                </div>


            </div>
        </div>

        <div class="tab-pane fade" id="detail-pic" role="tabpanel">
            <div class="row g-1 form-block">
                @if (!empty($image))
                    @foreach ($image as $key => $value)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <img class="card-img-top img-fluid w-150 h-150"
                                    src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                    alt="{{ $value->file_name }}" />
                            </div>
                        </div>
                    @endforeach
                @else
                    ไม่พบข้อมูลรูปภาพ
                @endif
            </div>
        </div>
    </div>
</div>
{{-- @section('script') --}}
<script type="text/javascript" src="{{ asset('/assets/custom/service/approveCaseAction.js?v=') }}@php echo date("H:i:s") @endphp"></script>
{{-- @endsection --}}
