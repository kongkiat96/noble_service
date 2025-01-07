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
                            <label class="form-label-md mb-2" for="status_name">รายการสถานะ</label>
                            <input type="text" id="status_name" class="form-control" name="status_name"
                                autocomplete="off" />
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status_use">รูปแบบการใช้งาน</label>
                            <select id="status_use" name="status_use" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                <option value="it">ใช้งานฝ่าย IT</option>
                                <option value="mt">ใช้งานฝ่ายอาคาร</option>
                                {{-- <option value="hr">ใช้งานฝ่าย HR</option> --}}
                                <option value="all">ใช้งานทุกระบบ</option>
                            </select>
                        </div>
                        {{-- {{ dd($group_status) }} --}}
                        <div class="col-md-12 mt-2">
                            <label class="form-label-md mb-2" for="group_status">รูปแบบสถานะทำงาน</label>
                            <select id="group_status" name="group_status" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                @foreach ($dataGroupStatus as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->group_status_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label-md mb-2" for="status">สถานะการใช้งาน</label>
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
