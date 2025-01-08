<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขรายการสถานะ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <form id="formEditStatus" class="form-block">
        {{-- {{ dd($dataStatus->status_name) }} --}}
        <div class="modal-body pt-0">
            <div class="row g-2">
                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_name">รายการสถานะ <span class="text-danger">*</span></label>
                    <input type="text" id="status_name" class="form-control" name="status_name"
                        autocomplete="off" value="{{ $dataStatus->status_name }}"/>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_color">สีรายการสถานะ <span class="text-danger">*</span></label>
                    <input type="color" id="status_color" class="form-control" name="status_color"
                        autocomplete="off" style="height: 40px" value="{{ $dataStatus->status_color  }}"/>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_use">การใช้งานสำหรับฝ่าย <span class="text-danger">*</span></label>
                    <select id="status_use" name="status_use" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="it" @if($dataStatus->status_use == 'it') selected @endif>ใช้งานฝ่าย IT</option>
                        <option value="mt" @if($dataStatus->status_use == 'mt') selected @endif>ใช้งานฝ่ายอาคาร</option>
                        <option value="all" @if($dataStatus->status_use == 'all') selected @endif>ใช้งานทุกระบบ</option>
                    </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_show">การแสดงผลสถานะ <span class="text-danger">*</span></label>
                    <select id="status_show" name="status_show" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="admin" @if($dataStatus->status_show == 'admin') selected @endif>แสดงสำหรับเจ้าหน้าที่</option>
                        <option value="user" @if($dataStatus->status_show == 'user') selected @endif>แสดงสำหรับผู้แจ้ง</option>
                        <option value="all" @if($dataStatus->status_show == 'all') selected @endif>แสดงทั้งหมด</option>
                    </select>
                </div>
                {{-- {{ dd($group_status) }} --}}
                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="group_status">กลุ่มสถานะ <span class="text-danger">*</span></label>
                    <select id="group_status" name="group_status" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach ($dataGroupStatus as $key => $value)
                            <option value="{{ $value->id }}" @if($dataStatus->group_status == $value->id) selected @endif>{{ $value->group_status_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status">สถานะการใช้งาน <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select select2"
                        data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1" @if($dataStatus->status == '1') selected @endif>กำลังใช้งาน</option>
                        <option value="0" @if($dataStatus->status == '0') selected @endif>ปิดการใช้งาน</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                    class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
                <input type="text" hidden id="statusID" name="statusID" value="{{ $dataStatus->ID }}">
            <button type="submit" name="saveEditStatus" id="saveEditStatus"
                class="btn btn-warning btn-form-block-overlay"><i
                    class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ asset('/assets/custom/settings/status/func_edit.js?v=') }}@php echo date("H:i:s") @endphp"></script>
