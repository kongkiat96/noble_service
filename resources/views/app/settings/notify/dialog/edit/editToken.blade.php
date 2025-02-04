<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขรายการแจ้งเตือนผ่าน Telegram</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <hr>
    <form id="formEditTokenTelegram" class="form-block">
        <div class="modal-body pt-0">
            <div class="row g-2">
                <div class="col-md-12 mt-2">
                    <label class="form-label-md mb-2" for="token">Token <span class="text-danger">*</span></label>
                    <input type="text" id="token" class="form-control" name="token"
                        autocomplete="off" value="{{ $dataTelegram->token }}"/>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="alert_type">เลือกประเภทการส่งข้อมูล<span class="text-danger">*</span></label>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-check form-check-info form-check-inline">
                                <input name="alert_type" class="form-check-input" type="radio" value="alert_only" id="alert_only" @if($dataTelegram->alert_type == 'alert_only') checked @endif/>
                                <label class="form-check-label" for="alert_only">Chat ID</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-info form-check-inline">
                                <input name="alert_type" class="form-check-input" type="radio" value="alert_group" id="alert_group" @if($dataTelegram->alert_type == 'alert_group') checked @endif/>
                                <label class="form-check-label" for="alert_group">Group ID</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="chat_id">Chat ID<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          {{-- placeholder="ระบบจะทำการดึงค่าให้อัตโนมัติ" --}}
                          {{-- aria-label="ระบบจะทำการดึงค่าให้อัตโนมัติ" --}}
                          aria-describedby="searchChatID" id="chat_id" name="chat_id" value="{{ $dataTelegram->chat_id }}"/>
                        {{-- <button class="btn btn-outline-primary" type="button" id="searchChatID"><i class="bx bx-search"></i></button> --}}
                      </div>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="use_tag">การใช้งานสำหรับฝ่าย <span class="text-danger">*</span></label>
                    <select id="use_tag" name="use_tag" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="it" @if($dataTelegram->use_tag == 'it') selected @endif>ใช้งานฝ่าย IT</option>
                        <option value="mt" @if($dataTelegram->use_tag == 'mt') selected @endif>ใช้งานฝ่ายช่าง</option>
                        <option value="permission" @if($dataTelegram->use_tag == 'permission') selected @endif>ใช้งานสำหรับอนุมัติสิทธิ์</option>
                        <option value="all" @if($dataTelegram->use_tag == 'all') selected @endif>ใช้งานทุกระบบ</option>
                    </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label class="form-label-md mb-2" for="status_use">สถานะการใช้งาน <span class="text-danger">*</span></label>
                    <select id="status_use" name="status_use" class="form-select select2"
                        data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="1" @if($dataTelegram->status_use == '1') selected @endif>กำลังใช้งาน</option>
                        <option value="0" @if($dataTelegram->status_use == '0') selected @endif>ปิดการใช้งาน</option>
                    </select>
                </div>
            </div>
            <input type="text" name="telegramID" id="telegramID" value="{{ $dataTelegram->id }}" hidden>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                    class='menu-icon tf-icons bx bx-window-close'></i> ปิด</button>

            <button type="submit" name="editNotiTelegram" id="editNotiTelegram"
                class="btn btn-warning btn-form-block-overlay"><i
                    class='menu-icon tf-icons bx bxs-save'></i> บันทึกข้อมูล</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ asset('/assets/custom/settings/notify/func_edit.js?v=') }}@php echo date("H:i:s") @endphp"></script>
