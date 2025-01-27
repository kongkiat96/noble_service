<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลผู้ใต้บังคับบัญชา</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formAddSubManager" class="form-block">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="sub_emp_id">รายชื่อพนักงาน</label>
                        <select id="sub_emp_id" name="sub_emp_id" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($getDataEmployee as $key => $value)
                            @if ($value->ID != $dataManager->manager_emp_id)
                                <option value="{{ $value->ID }}">{{ $value->full_name }}</option>
                            @endif
                                {{-- <option value="{{ $value->ID }}">{{ $value->full_name }}</option> --}}
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1">กำลังใช้งาน</option>
                            <option value="0">ปิดการใช้งาน</option>
                        </select>
                    </div>
                </div>
                <input type="text" name="manager_id" id="manager_id" value="{{ $managerID }}" hidden>
            </form>
            <div class="divider mt-4">
                <div class="divider-text font-weight-bold font-size-lg">ข้อมุลเกี่ยวกับพนักงาน</div>
              </div>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="company_name_th">บริษัท</label>
                        <input type="text" id="company_name_th" class="form-control" name="company_name_th"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="class_name">ระดับตำแหน่ง</label>
                        <input type="text" id="class_name" class="form-control" name="class_name"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="position_name">ตำแหน่ง</label>
                        <input type="text" id="position_name" class="form-control" name="position_name"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="department_name">สังกัด / ฝ่าย</label>
                        <input type="text" id="department_name" class="form-control" name="department_name"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="group_name">แผนก</label>
                        <input type="text" id="group_name" class="form-control" name="group_name"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_name">ชื่อสาขา (เต็ม)</label>
                        <input type="text" id="branch_name" class="form-control" name="branch_name"
                            autocomplete="off" readonly/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="branch_code">ชื่อสาขา (ย่อ)</label>
                        <input type="text" id="branch_code" class="form-control" name="branch_code"
                            autocomplete="off" readonly/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

        <button type="submit" name="saveSubManager" id="saveSubManager" class="btn btn-success btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>
    <script type="text/javascript" src="{{ asset('/assets/custom/employee/manager/func_save.js?v=') }}@php echo date("H:i:s") @endphp"></script>
