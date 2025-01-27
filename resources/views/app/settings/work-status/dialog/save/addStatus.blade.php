        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มรายการสถานะ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <form id="formAddStatus" class="form-block">
                <div class="modal-body pt-0">
                    <div class="row g-2">
                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status_name">รายการสถานะ <span class="text-danger">*</span></label>
                            <input type="text" id="status_name" class="form-control" name="status_name"
                                autocomplete="off" />
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status_color">สีรายการสถานะ <span class="text-danger">*</span></label>
                            <input type="color" id="status_color" class="form-control" name="status_color"
                                autocomplete="off" style="height: 40px"/>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status_use">การใช้งานสำหรับฝ่าย <span class="text-danger">*</span></label>
                            <select id="status_use" name="status_use" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                <option value="it">ใช้งานฝ่าย IT</option>
                                <option value="mt">ใช้งานฝ่ายอาคาร</option>
                                <option value="all">ใช้งานทุกระบบ</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status_show">การแสดงผลสถานะ <span class="text-danger">*</span></label>
                            <select id="status_show" name="status_show" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                {{-- <option value="admin">แสดงสำหรับเจ้าหน้าที่</option>
                                <option value="user">แสดงสำหรับผู้แจ้ง</option> --}}
                                <option value="all">แสดงทั้งหมด</option>
                            </select>
                        </div>
                        {{-- {{ dd($group_status) }} --}}
                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="group_status">กลุ่มสถานะ <span class="text-danger">*</span></label>
                            <select id="group_status" name="group_status" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                @foreach ($dataGroupStatus as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->group_status_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status">สถานะการใช้งาน <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select select2"
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

                    <button type="submit" name="saveStatus" id="saveStatus"
                        class="btn btn-success btn-form-block-overlay"><i
                            class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
                </div>
            </form>
        </div>

        <script type="text/javascript" src="{{ asset('/assets/custom/settings/status/func_save.js?v=') }}@php echo date("H:i:s") @endphp"></script>
