<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มรายการแจ้งขอตรวจสอบ CCTV</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <form id="formAddCaseCCTV" class="form-block">
        <div class="modal-body pt-0">
            <div class="row g-2">
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_main">รายการกลุ่มอุปกรณ์ <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="category_main" id="category_main" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryMain as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->category_main_name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_type">รายการประเภทหมวดหมู่ <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="category_type" id="category_type" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryType as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->category_type_name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_detail">อาการที่ต้องการแจ้งปัญหา <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="category_detail" id="category_detail" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryDetail as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->category_detail_name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_use">สถานะการใช้งาน <span class="text-danger">*</span></label>
                    <select id="status_use" name="status_use" class="form-select select2"
                        data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1">กำลังใช้งาน</option>
                        <option value="0">ปิดการใช้งาน</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                    class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

            <button type="submit" name="saveCaseCCTV" id="saveCaseCCTV"
                class="btn btn-success btn-form-block-overlay"><i
                    class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ asset('/assets/custom/settings/caseApproveSpecial/func_save.js?v=') }}@php echo date("H:i:s") @endphp"></script>
<script>
    mapSelectedCategory('#category_type', '#category_main', true)
    mapSelectedCategoryDetail('#category_detail', '#category_type', true)
</script>