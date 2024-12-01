<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลรายการอุปกรณ์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <div class="modal-body pt-0">
        <div class="row g-1">
            <form id="formAddAssetType" class="form-block">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="asset_type_name">รายการอุปกรณ์</label>
                        <input type="text" id="asset_type_name" class="form-control" name="asset_type_name" autocomplete="off" />
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label class="form-label-md mb-2" for="asset_tag_id">กลุ่มสินทรัพย์</label>
                    <select id="asset_tag_id" name="asset_tag_id" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach ($getDataAssetsTag as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->asset_tag_name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                

                <div class="col-md-12">
                    <label class="form-label-md mb-2" for="status_type">สถานะการใช้งาน</label>
                    <select id="status_type" name="status_type" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1">กำลังใช้งาน</option>
                        <option value="0">ปิดการใช้งาน</option>
                    </select>
                </div>

                {{-- <div class="col-md-12">
                    <label class="form-label-md mb-2" for="status_type">สถานะการใช้งาน</label>
                    <select id="status_type" name="status_type" class="form-select select2" data-allow-clear="true">
                        <optgroup label="A">
                            <option value="1">กำลังใช้งาน</option>
                            <option value="0">ปิดการใช้งาน</option>
                        </optgroup>
                        <optgroup label="B">
                            <option value="1">กำลังใช้งาน</option>
                        </optgroup>
                    </select>
                </div> --}}
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

        <button type="submit" name="saveAssetType" id="saveAssetType" class="btn btn-success btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
    </div>

    <script type="text/javascript" src="{{ asset('/assets/custom/assetsManagement/settingsAsset/func_save.js?v=') }}@php echo date("H:i:s") @endphp">
    </script>
