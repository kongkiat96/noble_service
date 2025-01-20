<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">ตรวจสอบรายการแจ้งปัญหาฝ่ายงาน <u>{{ $data['use_tag'] }}</u></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#detail-case" aria-controls="#detail-case" aria-selected="true">
                        รายละเอียดการแจ้งปัญหา
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#detail-pic" aria-controls="#detail-pic" aria-selected="true">
                        รายการรูปภาพ
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#detail-history" aria-controls="#detail-history" aria-selected="true"
                        id="reTabA">
                        ประวัติการบันทึกข้อมูล
                    </button>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="detail-case" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="divider">
                                <div class="divider-text font-weight-bold font-size-lg text-info">ส่วนของผู้แจ้ง</div>
                            </div>
                            <div class="row g-1">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2" for="ticket">Ticket</label>
                                    <input type="text" class="form-control" value="{{ $data['ticket'] }}" readonly
                                        autofocus>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2"
                                        for="category_main_name">รายการกลุ่มอุปกรณ์</label>
                                    <input type="text" class="form-control" value="{{ $data['category_main_name'] }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2"
                                        for="category_type_name">รายการประเภทหมวดหมู่</label>
                                    <input type="text" class="form-control" value="{{ $data['category_type_name'] }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2"
                                        for="category_detail_name">อาการที่ต้องการแจ้งปัญหา</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data['category_detail_name'] }}" readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2" for="asset_number">หมายเลขครุภัณฑ์</label>
                                    <input type="text" class="form-control" value="{{ $data['asset_number'] }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2"
                                        for="employee_other_case_name">ผู้แจ้งปัญหา</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data['employee_other_case_name'] }}" readonly>
                                </div>
                                @if ($data['manager_name'] != null)
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label-md mb-2" for="manager_name">ผู้บังคับบัญชา</label>
                                        <input type="text" class="form-control" value="{{ $data['manager_name'] }}"
                                            readonly>
                                    </div>
                                @endif
                                <div class="col-md-12 mb-2">
                                    <label class="form-label-md mb-2" for="case_detail">รายละเอียด</label>
                                    <textarea rows="3" class="form-control" readonly>{{ $data['case_detail'] }}</textarea>
                                </div>

                                <div class="divider">
                                    <div class="divider-text font-weight-bold font-size-lg">สถานะตรวจสอบการทำงาน</div>
                                </div>
                                <form id="formCaseCheckWork" class="form-block">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label-md mb-2" for="case_status">สถานะตรวจสอบการทำงาน <span
                                                class="text-danger">*</span></label>
                                        <select name="case_status" id="case_status" class="form-select select2"
                                            data-allow-clear="true">
                                            <option value=""></option>
                                            {{-- @foreach ($getStatusWork as $key)
                                                @if (!in_array($key->ID, [99999]))
                                                    <option value="{{ $key->ID }}">{{ $key->status_name }}</option>
                                                @endif
                                            @endforeach --}}
                                            <option value="case_success_user">ผ่านการตรวจสอบ / ดำเนินงานเรียบร้อย
                                            </option>
                                            <option value="case_reject">ไม่ผ่านการตรวจสอบ / ดำเนินงานไม่เรียบร้อย
                                            </option>
                                        </select>
                                    </div>
                                    <input type="text" name="tagStep" id="tagStep" value="userCheckWork"
                                        hidden>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-6" style="border-left: 2px solid #e0e0e0">
                            <div class="divider">
                                <div class="divider-text font-weight-bold font-size-lg text-warning">ส่วนของเจ้าหน้าที่
                                </div>
                            </div>
                            <div class="row g-1">
                                {{-- <div class="row"> --}}
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2" for="case_item">รายการที่เสีย </label>
                                    <select class="form-control select2" data-allow-clear="true" disabled>
                                        <option value="">เลือกรายการ</option>
                                        @foreach ($categoryItem as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($data['case_item'] == $item->id) selected @endif>
                                                {{ $item->category_item_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label-md mb-2" for="case_list">รายการที่แก้ไขปัญหา </label>
                                    <select class="form-control select2" data-allow-clear="true" disabled>
                                        <option value="">เลือกรายการ</option>
                                        @foreach ($categoryList as $list)
                                            <option value="{{ $list->id }}"
                                                @if ($data['case_list'] == $list->id) selected @endif>
                                                {{ $list->category_list_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label-md mb-2" for="sla">SLA</label>
                                    <input type="text" class="form-control" readonly value="{{ $data['sla'] }}">
                                </div>
                                <div class="col-md-9 mb-2">
                                    <label class="form-label-md mb-2" for="case_price">ค่าใช้จ่าย</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control numeral-mask text-end"
                                            placeholder="ค่าใช้จ่าย" oninput="formatAmount(this)"
                                            value="{{ $data['price'] }}" disabled />
                                        <span class="input-group-text">฿</span>
                                    </div>



                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="worker" class="form-label-md mb-2">ช่างผู้ปฏิบัติงาน /
                                        รับผิดชอบ</label>
                                    <input class="form-control" value="{{ $workerNames }}" disabled />
                                    {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="worker" class="form-label-md mb-2">ผู้รับเหมา / ซัพนอก</label>
                                    <input class="form-control" value="{{ $checkerNames }}" disabled />
                                    {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                                </div>

                            </div>
                            @if (!empty($data['case_end']))
                                <div class="col-md-6">
                                    <label class="form-label-md mb-2" for="case_end">วันที่ดำเนินงานเรียบร้อย</label>
                                    <input type="text" id="case_end" class="form-control" name="case_end"
                                        readonly value="{{ $data['case_end'] }}">
                                    <label class="form-label-sm mt-2 text-danger"
                                        for="case_end">นับจากวันที่ผู้แจ้งตรวจสอบงานเรียบร้อย</label>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label-md mb-2" for="calSLA">ระยะเวลาที่คำนวณแล้ว</label>
                                    <input type="text" id="calSLA" class="form-control" name="calSLA"
                                        readonly value="{{ $data['calSLA']['message'] }}">
                                    <label class="form-label-sm mt-2 text-danger"
                                        for="calSLA">นับจากวันที่ผู้แจ้งตรวจสอบงานเรียบร้อย</label>
                                </div>
                            @else
                                <div class="col-md-6">

                                    <label class="form-label-md mb-2"
                                        for="case_end">วันที่ดำเนินงานต้องแล้วเสร็จ</label>
                                    <input type="text" id="case_end" class="form-control" name="case_end"
                                        readonly value="{{ $data['calSLANullCaseEnd'] }}">
                                    @if (\Carbon\Carbon::now() > $data['calSLANullCaseEnd'])
                                        <label class="form-label-sm mt-2 text-danger"
                                            for="case_end">ขณะนี้เกินระยะเวลาที่กำหนด</label>
                                    @endif
                                </div>

                            @endif
                        </div>
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
                                        <div class="col-md-3 mb-3">
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
                        <div class="tab-pane fade" id="after-pic" role="tabpanel">
                            <div class="row g-1 form-block">
                                @if (!empty($imageDoing))
                                    @foreach ($imageDoing as $key => $value)
                                        <div class="col-md-3 mb-3">
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

                <div class="tab-pane fade" id="detail-history" role="tabpanel">
                    {{-- <div class="row g-1 form-block"> --}}
                    <div class="text-nowrap table-responsive">
                        <table class="dt-approve-history table table-bordered table-hover table-striped"
                            style="width: 100%">
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

                    <input type="text" name="caseID" value="{{ $data['id'] }}" hidden id="caseID">
                </div>
            </div>




        </div>



    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

        <button type="submit" name="saveCaseCheckWork" id="saveCaseCheckWork"
            class="btn btn-success btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
            บันทึกข้อมูล</button>
    </div>

    <script src="{{ asset('/assets/custom/service/approveCaseAction.js?v=') }}@php echo date("H:i:s") @endphp"></script>
