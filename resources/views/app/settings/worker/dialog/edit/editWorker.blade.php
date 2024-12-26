<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แกไขข้อมูลผู้ปฏิบัติงาน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditWorker" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="employee_id">รายชื่อพนักงาน <span class="text-danger">*</span></label>
                        <select id="employee_id" name="employee_id" class="form-select select2"
                            data-allow-clear="true" data-modal-id="edit">
                            <option value="">Select</option>
                            @foreach ($getDataEmployee as $key => $value)
                                <option value="{{ $value->ID }}" @if ($value->ID == $getDataWorker->employee_id) selected @endif>{{ $value->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="use_tag">การปฏิบัติงานของฝ่าย <span class="text-danger">*</span></label>
                        <select id="use_tag" name="use_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="it" @if($getDataWorker->use_tag == 'it') selected @endif>ปฏิบัติงานเฉพาะ ITs</option>
                            <option value="mt" @if($getDataWorker->use_tag == 'mt') selected @endif>ปฏิบัติงานเฉพาะ MTs</option>
                            <option value="all" @if($getDataWorker->use_tag == 'all') selected @endif>ทำงานทั้งหมด</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน <span class="text-danger">*</span></label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1" @if($getDataWorker->status_tag == 1) selected @endif>กำลังใช้งาน</option>
                            <option value="0" @if($getDataWorker->status_tag == 0) selected @endif>ปิดการใช้งาน</option>
                        </select>
                    </div>


                </div>
            </form>
            <div class="divider mt-4">
                <div class="divider-text font-weight-bold font-size-lg">ข้อมุลเกี่ยวกับพนักงาน</div>
            </div>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="company_name_th_edit">บริษัท</label>
                        <input type="text" id="company_name_th_edit" class="form-control" name="company_name_th_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->company_name_th }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="class_name_edit">ระดับตำแหน่ง</label>
                        <input type="text" id="class_name_edit" class="form-control" name="class_name_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->class_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="position_name_edit">ตำแหน่ง</label>
                        <input type="text" id="position_name_edit" class="form-control" name="position_name_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->position_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="department_name_edit">สังกัด / ฝ่าย</label>
                        <input type="text" id="department_name_edit" class="form-control" name="department_name_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->department_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="group_name_edit">แผนก</label>
                        <input type="text" id="group_name_edit" class="form-control" name="group_name_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->group_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_name_edit">ชื่อสาขา (เต็ม)</label>
                        <input type="text" id="branch_name_edit" class="form-control" name="branch_name_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->branch_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_code_edit">ชื่อสาขา (ย่อ)</label>
                        <input type="text" id="branch_code_edit" class="form-control" name="branch_code_edit"
                            autocomplete="off" value="{{ $getDataOnSelect->branch_code }}" readonly/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
            <input type="text" name="workerID" id="workerID" value="{{ $getDataWorker->id }}" hidden>
        <button type="submit" name="saveEditWorker" id="saveEditWorker" class="btn btn-warning btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/custom/settings/worker/func_edit.js?v=') }}@php echo date("H:i:s") @endphp"></script>
