<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลผู้บังคับบัญชา</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditManager" class="form-block">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="manager_emp_id">รายชื่อพนักงาน</label>
                        <select id="manager_emp_id" name="manager_emp_id" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($getDataEmployee as $key => $value)
                                <option value="{{ $value->ID }}" @if ($dataManager->manager_emp_id == $value->ID) selected @endif>{{ $value->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1" @if ($dataManager->status_tag == 1) selected @endif>กำลังใช้งาน</option>
                            <option value="0" @if ($dataManager->status_tag == 0) selected @endif>ปิดการใช้งาน</option>
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
                        <label class="form-label-md mb-2" for="company_name_th">บริษัท</label>
                        <input type="text" id="company_name_th" class="form-control" name="company_name_th"
                            autocomplete="off" value="{{ $getDataOnSelect->company_name_th }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="class_name">ระดับตำแหน่ง</label>
                        <input type="text" id="class_name" class="form-control" name="class_name"
                            autocomplete="off" value="{{ $getDataOnSelect->class_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="position_name">ตำแหน่ง</label>
                        <input type="text" id="position_name" class="form-control" name="position_name"
                            autocomplete="off" value="{{ $getDataOnSelect->position_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="department_name">สังกัด / ฝ่าย</label>
                        <input type="text" id="department_name" class="form-control" name="department_name"
                            autocomplete="off" value="{{ $getDataOnSelect->department_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="group_name">แผนก</label>
                        <input type="text" id="group_name" class="form-control" name="group_name"
                            autocomplete="off" value="{{ $getDataOnSelect->group_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_name">ชื่อสาขา (เต็ม)</label>
                        <input type="text" id="branch_name" class="form-control" name="branch_name"
                            autocomplete="off" value="{{ $getDataOnSelect->branch_name }}" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_code">ชื่อสาขา (ย่อ)</label>
                        <input type="text" id="branch_code" class="form-control" name="branch_code"
                            autocomplete="off" value="{{ $getDataOnSelect->branch_code }}" readonly/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
            <input type="text" name="managerID" id="managerID" value="{{ $dataManager->id }}" hidden>
        <button type="submit" name="saveEditManager" id="saveEditManager" class="btn btn-warning btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/custom/employee/manager/func_edit.js?v=') }}@php echo date("H:i:s") @endphp"></script>
