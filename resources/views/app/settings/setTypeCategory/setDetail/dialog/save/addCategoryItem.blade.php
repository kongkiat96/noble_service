<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลสาเหตุที่เสีย</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formAddCategoryItem" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_item_name">สาเหตุที่เสีย</label>
                        <input type="text" id="category_item_name" class="form-control" name="category_item_name"
                            autocomplete="off" />
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
                <input type="text" name="categoryAllID" id="categoryAllID" value="{{ $categoryDetailID }}" hidden>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

        <button type="submit" name="saveCategoryItem" id="saveCategoryItem" class="btn btn-success btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript" src="{{ asset('/assets/custom/settings/setTypeCategory/func_save.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
