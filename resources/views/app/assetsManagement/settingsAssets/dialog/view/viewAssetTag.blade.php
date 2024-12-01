<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">ตรวจสอบข้อมูลรายการประเภทสินทรัพย์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formEditAssetTag" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="asset_tag_name">รายการสินทรัพย์</label>
                        <input type="text" id="asset_tag_name" class="form-control" name="asset_tag_name"
                            autocomplete="off" value="{{ $getDataAssetTag->asset_tag_name }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="asset_tag_color">สีรายการสินทรัพย์</label>
                        <input type="color" id="asset_tag_color" class="form-control" style="height: 40px" name="asset_tag_color" autocomplete="off" value="{{ $getDataAssetTag->asset_tag_color }}" />
                    </div>
                </div>
                

                <div class="col-md-12">
                    <label class="form-label-md mb-2" for="status_tag">สถานะการใช้งาน</label>
                    <select id="status_tag" name="status_tag" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1" @if ($getDataAssetTag->status_tag == 1) selected @endif>กำลังใช้งาน
                        </option>
                        <option value="0" @if ($getDataAssetTag->status_tag == 0) selected @endif>ปิดการใช้งาน
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>
    </div>

