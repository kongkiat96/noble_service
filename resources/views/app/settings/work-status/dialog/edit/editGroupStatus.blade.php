<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขกลุ่มรายการสถานะ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <form id="formEditGroupStatus" class="form-block">
        <div class="modal-body pt-0">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label-md mb-2" for="group_status_th">ชื่อกลุ่มสถานะ (ภาษาไทย) <span
                            class="text-danger">*</span></label>
                    <input type="text" id="group_status_th" class="form-control" name="group_status_th"
                        autocomplete="off" value="{{ $dataGroupStatus->group_status_th }}" />
                </div>

                <div class="col-md-6">
                    <label class="form-label-md mb-2" for="group_status_en">ชื่อกลุ่มสถานะ (ภาษาอังกฤษ) <span
                            class="text-danger">*</span></label>
                    <input type="text" id="group_status_en" class="form-control" name="group_status_en"
                        autocomplete="off" value="{{ $dataGroupStatus->group_status_en }}" />
                </div>

                <div class="col-md-6">
                    <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน <span
                            class="text-danger">*</span></label>
                    <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1" @if ($dataGroupStatus->status_tag == '1') selected @endif>กำลังใช้งาน</option>
                        <option value="0" @if ($dataGroupStatus->status_tag == '0') selected @endif>ปิดการใช้งาน</option>
                    </select>
                </div>
                <div class="divider mt-4">
                    <div class="divider-text font-weight-bold font-size-lg">หมายเหตุ</div>
                </div>
                <div class="col-12">
                    <h5><span class="text-danger">*** สำหรับกำหนดกลุ่มเพื่อบ่งบอกสถานะงานนั้น ๆ ***</span></h5>

                </div>
            </div>


        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                    class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
            <input type="text" name="groupStatusID" id="groupStatusID" value="{{ $id }}" hidden>
            <button type="submit" name="saveEditGroupStatus" id="saveEditGroupStatus"
                class="btn btn-success btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
                บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script type="text/javascript"src="{{ asset('/assets/custom/settings/status/func_edit.js?v=') }}@php echo date("H:i:s") @endphp"></script>

