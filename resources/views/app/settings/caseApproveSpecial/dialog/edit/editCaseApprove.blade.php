<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขรายการ{{ $setTitle }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <form id="formEditCaseApprove" class="form-block">
        <div class="modal-body pt-0">
            <div class="row g-2">
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_main_edit">รายการกลุ่มอุปกรณ์ <span
                            class="text-danger">*</span></label>
                    <select class="form-select select2" name="category_main_edit" id="category_main_edit" data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach ($dataCategoryMain as $key => $value)
                            <option value="{{ $value->id }}" @if ($dataCaseApprove->category_main == $value->id) selected @endif>
                                {{ $value->category_main_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_type_edit">รายการประเภทหมวดหมู่ <span
                            class="text-danger">*</span></label>
                    <select class="form-select select2" name="category_type_edit" id="category_type_edit" data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach ($dataCategoryType as $key => $value)
                            <option value="{{ $value->id }}" @if ($dataCaseApprove->category_type == $value->id) selected @endif>
                                {{ $value->category_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_detail_edit">อาการที่ต้องการแจ้งปัญหา <span
                            class="text-danger">*</span></label>
                    <select class="form-select select2" name="category_detail_edit" id="category_detail_edit"
                        data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach ($dataCategoryDetail as $key => $value)
                            <option value="{{ $value->id }}" @if ($dataCaseApprove->category_detail == $value->id) selected @endif>
                                {{ $value->category_detail_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_use">สถานะการใช้งาน <span
                            class="text-danger">*</span></label>
                    <select id="status_use" name="status_use" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1" @if ($dataCaseApprove->status_use == 1) selected @endif>กำลังใช้งาน</option>
                        <option value="0" @if ($dataCaseApprove->status_use == 0) selected @endif>ปิดการใช้งาน</option>
                    </select>
                </div>
            </div>
            <input type="text" name="caseApproveID" id="caseApproveID" value="{{ encrypt($dataCaseApprove->id) }}" hidden>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                    class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

            <button type="submit" name="saveEditCaseCCTV" id="saveEditCaseCCTV"
                class="btn btn-warning btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
                บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script type="text/javascript"
    src="{{ asset('/assets/custom/settings/caseApproveSpecial/func_edit.js?v=') }}@php echo date("H:i:s") @endphp">
</script>
<script>
    mapSelectedCategory('#category_type_edit', '#category_main_edit', false)
    mapSelectedCategoryDetail('#category_detail_edit', '#category_type_edit', false)
</script>
