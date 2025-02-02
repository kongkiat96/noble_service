<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายละเอียดการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-pic"
                aria-controls="#detail-pic" aria-selected="true">
                รูปภาพการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-history"
                aria-controls="#detail-history" aria-selected="true" id="reTabA">
                ประวัติการบันทึกข้อมูล
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
                    @if ($data['manager_name'] != null)
                        <div class="col-md-12 mb-4">
                            <label class="form-label-md mb-2" for="manager_name">ผู้บังคับบัญชา</label>
                            <input type="text" id="manager_name" class="form-control" name="manager_name"
                                value="{{ $data['manager_name'] }}" readonly>
                        </div>
                    @endif
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_detail">รายละเอียด</label>
                        <textarea id="case_detail" name="case_detail" rows="3" class="form-control" readonly>{{ $data['case_detail'] }}</textarea>
                    </div>
                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">บันทึกสถานะการอนุมัติงาน</div>
                    </div>
                </div>
                <form id="formApproveToPadding">
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_status">สถานะการอนุมัติงาน</label>
                        {{-- <select name="case_status" id="case_status" class="form-select select2"
                            data-allow-clear="true">
                            <option value=""></option>
                            <option value="manager_{{ $setLowercase }}_approve">อนุมัติดำเนินการแจ้งซ่อม</option>
                            <option value="reject_manager_{{ $setLowercase }}_approve">ไม่อนุมัติดำเนินการแจ้งซ่อม</option>
                        </select> --}}
                        <div class="row m-2">
                            <div class="col-md-6">
                                <div class="form-check form-check-success form-check-inline">
                                    <input name="case_status" class="form-check-input" type="radio"
                                        value="manager_{{ $setLowercase }}_approve" id="rm_approve" />
                                    <label class="form-check-label" for="rm_approve"> อนุมัติดำเนินการ </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-danger form-check-inline">
                                    <input name="case_status" class="form-check-input" type="radio"
                                        value="reject_manager_{{ $setLowercase }}_approve" id="rm_reject" />
                                    <label class="form-check-label" for="rm_reject"> ไม่อนุมัติดำเนินการ </label>
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

                    <button type="submit" name="approveCaseToPadding" id="approveCaseToPadding"
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
                                <!-- กดที่ภาพเพื่อเปิด Modal -->
                                <img class="card-img-top img-fluid w-150 h-150" style="cursor: pointer;"
                                    src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                    alt="{{ $value->file_name }}" data-bs-toggle="modal"
                                    data-bs-target="#imageModal{{ $key }}" />
                            </div>
                        </div>
                        <div class="modal fade" id="imageModal{{ $key }}"
                            aria-labelledby="imageModalLabel{{ $key }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            class="img-fluid" alt="{{ $value->file_name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    ไม่พบข้อมูลรูปภาพ
                @endif

            </div>
        </div>

        <div class="tab-pane fade" id="detail-history" role="tabpanel">
            {{-- <div class="row g-1 form-block"> --}}
            <div class="text-nowrap table-responsive">
                <table class="dt-approve-history table table-bordered table-hover table-striped" style="width: 100%">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>สถานะ</th>
                            <th class="text-center">รายละเอียด</th>
                            <th>ค่าใช้จ่าย</th>
                            <th>วัน / เวลาที่บันทึกข้อมูล</th>
                            <th>ผู้บันทึกข้อมูล</th>
                        </tr>
                    </thead>
                </table>
            </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
<script type="text/javascript"
    src="{{ asset('/assets/custom/caseService/approveCaseAction.js?v=') }}@php echo date("H:i:s") @endphp"></script>
