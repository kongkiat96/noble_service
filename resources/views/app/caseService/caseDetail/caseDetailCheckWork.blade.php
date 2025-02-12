<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายละเอียดการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#case-action"
                aria-controls="#case-action" aria-selected="true">
                บันทึกข้อมูลการดำเนินงาน
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-pic"
                aria-controls="#detail-pic" aria-selected="true">
                รายการรูปภาพ
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
            </div>
        </div>

        <div class="tab-pane fade" id="case-action" role="tabpanel">
            <div class="row g-1 form-block">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="case_item">รายการที่เสีย <span
                                class="text-danger">*</span></label>
                        <select id="case_item" name="case_item" class="form-control select2" data-allow-clear="true"
                            disabled>
                            <option value="">เลือกรายการ</option>
                            @foreach ($categoryItem as $item)
                                <option value="{{ $item->id }}" @if ($data['case_item'] == $item->id) selected @endif>
                                    {{ $item->category_item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="case_list">รายการที่แก้ไขปัญหา <span
                                class="text-danger">*</span></label>
                        <select id="case_list" name="case_list" class="form-control select2" data-allow-clear="true"
                            disabled>
                            <option value="">เลือกรายการ</option>
                            @foreach ($categoryList as $list)
                                <option value="{{ $list->id }}" @if ($data['case_list'] == $list->id) selected @endif>
                                    {{ $list->category_list_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label-md mb-2" for="sla">SLA</label>
                        <input type="text" id="sla" class="form-control" name="sla" readonly
                            value="{{ $data['sla'] }}">
                    </div>
                    <div class="col-md-9 mb-4">
                        <label class="form-label-md mb-2" for="case_price">ค่าใช้จ่าย</label>
                        {{-- <input type="text" id="case_price" class="form-control" name="case_price"
                                value=""> --}}

                        <div class="input-group">
                            <input type="text" class="form-control numeral-mask text-end" placeholder="ค่าใช้จ่าย"
                                name="case_price" id="case_price" oninput="formatAmount(this)"
                                value="{{ $data['price'] }}" disabled />
                            <span class="input-group-text">฿</span>
                        </div>



                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="worker" class="form-label-md mb-2">ช่างผู้ปฏิบัติงาน / รับผิดชอบ</label>
                        <input id="worker" name="worker" class="form-control"
                            placeholder="&nbsp ช่างผู้ปฏิบัติงาน / รับผิดชอบ" value="{{ $workerNames }}" disabled />
                        {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="checker" class="form-label-md mb-2">ผู้รับเหมา / ซัพนอก</label>
                        <input id="checker" name="checker" class="form-control"
                            placeholder="&nbsp ผู้รับเหมา / ซัพนอก" value="{{ $checkerNames }}" disabled />
                        {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                    </div>

                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">ข้อมูลระยะเวลาดำเนินงาน</div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="case_start">วันที่แจ้งงาน</label>
                        <input type="text" id="case_start" class="form-control" name="case_start" readonly
                            value="{{ $data['case_start'] }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="case_end">วันที่ดำเนินงานเรียบร้อย</label>
                        <input type="text" id="case_end" class="form-control" name="case_end" readonly
                            value="{{ $data['case_end'] }}">
                        <label class="form-label-sm mt-2 text-danger"
                            for="case_end">นับจากวันที่ผู้แจ้งตรวจสอบงานเรียบร้อย</label>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="calSLA">ระยะเวลาที่คำนวณแล้ว</label>
                        <input type="text" id="calSLA" class="form-control" name="calSLA" readonly
                            value="{{ $data['calSLA']['message'] }}">
                        <label class="form-label-sm mt-2 text-danger"
                            for="calSLA">นับจากวันที่ผู้แจ้งตรวจสอบงานเรียบร้อย</label>
                    </div>

                    @if ($data['use_tag_code'] != 'permission' && $data['case_status'] != 'case_status')
                        <div class="divider">
                            <div class="divider-text font-weight-bold font-size-lg">สถานะการตรวจสอบการทำงาน</div>
                        </div>
                    @endif
                </div>
                <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>
                {{-- <input type="text" name="tagStep" id="tagStep" value="managerCheckWork" hidden> --}}
                @if ($data['case_status'] != 'case_status')
                    <form id="formManagerCaseCheckWork">
                    <input type="text" name="tagStep" id="tagStep" value="managerCheckWork" hidden>

                        {{-- <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>
                        <input type="text" name="tagStep" id="tagStep" value="managerCheckWork" hidden> --}}
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label-md mb-2" for="case_status">สถานะการตรวจสอบการทำงาน <span
                                        class="text-danger">*</span></label>
                                {{-- <select name="case_status" id="case_status" class="form-select select2"
                                            data-allow-clear="true">
                                            <option value=""></option>
                                            <option value="manager_{{ $setLowercase }}_checkwork_success">ผ่านการตรวจสอบ / ดำเนินงานเรียบร้อย</option>
                                            <option value="reject_manager_{{ $setLowercase }}_checkwork_success">ไม่ผ่านการตรวจสอบ / ดำเนินงานไม่เรียบร้อย</option>
                                        </select> --}}
                                <div class="row m-2">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-success form-check-inline">
                                            <input name="case_status" class="form-check-input" type="radio"
                                                value="manager_{{ $setLowercase }}_checkwork_success"
                                                id="rm_approve" />
                                            <label class="form-check-label" for="rm_approve"> ผ่านการตรวจสอบ /
                                                ดำเนินงานเรียบร้อย </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-danger form-check-inline">
                                            <input name="case_status" class="form-check-input" type="radio"
                                                value="reject_manager_{{ $setLowercase }}_checkwork_success"
                                                id="rm_reject" />
                                            <label class="form-check-label" for="rm_reject"> ไม่ผ่านการตรวจสอบ /
                                                ดำเนินงานไม่เรียบร้อย </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label-md mb-2" for="case_detail">หมายเหตุเพิ่มเติม </label>
                                <textarea id="case_detail" name="case_detail" rows="3" class="form-control"></textarea>
                            </div>
                        </div>



                    </form>
                    <hr class="mt-4">
                    <div class="col-12 text-center">
                        {{-- set case status getDataStatusWork --}}
                        @if (in_array($data['group_status'], ['Success', 'success']))
                            <div class="alert alert-warning text-bold" role="alert">
                                รายการนี้อยู่ระหว่างตรวจสอบงาน
                            </div>
                        @else
                            <button type="submit" name="saveManagerCaseCheckWork" id="saveManagerCaseCheckWork"
                                class="btn btn-success btn-form-block-overlay"><i
                                    class='menu-icon tf-icons bx bxs-save'></i>
                                บันทึกข้อมูล</button>
                        @endif
                    </div>
                @endif

            </div>
        </div>

        <div class="tab-pane fade" id="detail-pic" role="tabpanel">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#before-pic" aria-controls="#before-pic" aria-selected="true">
                        ก่อนแก้ไขปัญหา
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#after-pic" aria-controls="#after-pic" aria-selected="true">
                        หลังแก้ไขปัญหา <span class="text-danger">(แสดง 5 รายการล่าสุด)</span>
                    </button>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="before-pic" role="tabpanel">
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
                <div class="tab-pane fade" id="after-pic" role="tabpanel">
                    <div class="row g-1 form-block">
                        @if (!empty($imageDoing))
                            @foreach ($imageDoing as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <!-- กดที่ภาพเพื่อเปิด Modal -->
                                        <img class="card-img-top img-fluid w-150 h-150" style="cursor: pointer;"
                                            src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            alt="{{ $value->file_name }}" data-bs-toggle="modal"
                                            data-bs-target="#imageModal_after{{ $key }}" />
                                    </div>
                                </div>
                                <div class="modal fade" id="imageModal_after{{ $key }}"
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
