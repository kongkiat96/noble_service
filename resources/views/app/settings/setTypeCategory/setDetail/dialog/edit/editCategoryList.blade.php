<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลอาการแก้ไข</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditCategoryList" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_item_id">สาเหตุที่เสีย</label>
                        <select id="category_item_id" name="category_item_id" class="form-select select2"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryItem as $key => $item)
                                <option value="{{ $item->id }}" @if ($item->id == $dataCategoryList->category_item_id) selected @endif>
                                    {{ $item->category_item_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="category_list_name">การแก้ใข</label>
                        <input type="text" id="category_list_name" class="form-control" name="category_list_name"
                            autocomplete="off" value="{{ $dataCategoryList->category_list_name }}" />
                    </div>

                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="checker_id">ผู้ตรวจเช็ค/ซ่อม</label>
                        <select id="checker_id" name="checker_id" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($datamasterChecker as $key => $item)
                                <option value="{{ $item->id }}" @if ($item->id == $dataCategoryList->checker_id) selected @endif>
                                    {{ $item->checker_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="pr_po">PR / PO</label>
                        <input type="text" id="pr_po" class="form-control" name="pr_po" autocomplete="off"
                            value="{{ $dataCategoryList->pr_po }}" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="order">สั่งของ</label>
                        <input type="text" id="order" class="form-control" name="order" autocomplete="off"
                            value="{{ $dataCategoryList->order }}" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="processing">ระยะดำเนินการ</label>
                        <input type="text" id="processing" class="form-control" name="processing" autocomplete="off"
                            value="{{ $dataCategoryList->processing }}" />
                    </div> --}}

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="sla">SLA</label>
                        <input type="text" id="sla" class="form-control" name="sla" autocomplete="off"
                            value="{{ $dataCategoryList->sla }}" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                        <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="1" @if ($dataCategoryList->status_tag == 1) selected @endif>กำลังใช้งาน
                            </option>
                            <option value="0" @if ($dataCategoryList->status_tag == 0) selected @endif>ปิดการใช้งาน
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
        <input type="text" name="categoryListID" id="categoryListID" value="{{ $dataCategoryList->id }}" hidden>
        <button type="submit" name="saveEditCategoryLiist" id="saveEditCategoryLiist"
            class="btn btn-warning btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
            บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript"
        src="{{ asset('/assets/custom/settings/setTypeCategory/func_edit.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
