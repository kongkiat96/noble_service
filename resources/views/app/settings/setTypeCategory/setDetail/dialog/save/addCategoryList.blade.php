<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลการแก้ไข</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formAddCategoryList" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_item_id">สาเหตุที่เสีย</label>
                        <select id="category_item_id" name="category_item_id" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryItem as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->category_item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_list_name">การแก้ใข</label>
                        <input type="text" id="category_list_name" class="form-control" name="category_list_name"
                            autocomplete="off" />
                    </div>

                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="checker_id">ผู้ตรวจเช็ค/ซ่อม</label>
                        <select id="checker_id" name="checker_id" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataChecker as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->checker_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="pr_po">PR / PO</label>
                        <input type="text" id="pr_po" class="form-control" name="pr_po"
                            autocomplete="off" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="order">สั่งของ</label>
                        <input type="text" id="order" class="form-control" name="order"
                            autocomplete="off" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="processing">ระยะดำเนินการ</label>
                        <input type="text" id="processing" class="form-control" name="processing"
                            autocomplete="off" />
                    </div> --}}

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="sla">SLA</label>
                        <input type="text" id="sla" class="form-control" name="sla"
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

        <button type="submit" name="saveCategoryList" id="saveCategoryList" class="btn btn-success btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript" src="{{ asset('/assets/custom/settings/setTypeCategory/func_save.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
