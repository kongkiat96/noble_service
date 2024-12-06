<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขรายการผู้ตรวจเช็ค / ซ่อม</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditChecker" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="checker_name">รายการผู้ตรวจเช็ค / ซ่อม</label>
                        <input type="text" id="checker_name" class="form-control" name="checker_name"
                            autocomplete="off" value="{{ $dataChecker->checker_name }}"/>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="use_tag">การใช้งานของฝ่าย</label>
                        <select id="use_tag" name="use_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="IT" @if ($dataChecker->use_tag == 'IT') selected @endif>ใช้งานเฉพาะ IT</option>
                            <option value="MT" @if ($dataChecker->use_tag == 'MT') selected @endif>ใช้งานเฉพาะ MT</option>
                            <option value="ALL" @if ($dataChecker->use_tag == 'ALL') selected @endif>ใช้งานทั้งหมด</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1" @if ($dataChecker->status_tag == '1') selected @endif>กำลังใช้งาน</option>
                            <option value="0" @if ($dataChecker->status_tag == '0') selected @endif>ปิดการใช้งาน</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
            <input type="text" name="checkerID" id="checkerID" value="{{ $dataChecker->id }}" hidden>
        <button type="submit" name="editChecker" id="editChecker" class="btn btn-warning btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript"
        src="{{ asset('/assets/custom/settings/checker/func_edit.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
