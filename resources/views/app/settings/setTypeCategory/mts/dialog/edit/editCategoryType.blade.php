<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลรายการประเภทหมวดหมู่</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditCategoryType" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_main_id">รายการกลุ่มอุปกรณ์</label>
                        <select class="form-select select2" name="category_main_id" id="category_main_id">
                            <option value="">Select</option>
                            @foreach ($dataCategoryMain as $key => $value)
                            <option value="{{ $value->id }}" @if ($dataCategoryType->category_main_id == $value->id ) selected @endif>{{ $value->category_main_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_type_name">รายการประเภทหมวดหมู่</label>
                        <input type="text" id="category_type_name" class="form-control" name="category_type_name"
                            autocomplete="off" value="{{ $dataCategoryType->category_type_name }}"/>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1" @if ($dataCategoryType->status_tag == 1) selected @endif>กำลังใช้งาน
                            </option>
                            <option value="0" @if ($dataCategoryType->status_tag == 0) selected @endif>ปิดการใช้งาน
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
        <input type="hidden" name="categoryTypeID" id="categoryTypeID" value="{{ $dataCategoryType->id }}">

        <button type="submit" name="saveEditCategoryType" id="saveEditCategoryType"
            class="btn btn-warning btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
            บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript"
        src="{{ asset('/assets/custom/settings/setTypeCategory/func_edit.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
