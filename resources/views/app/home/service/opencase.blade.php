<div class="row g-1">
    <form id="formAddManager" class="form-block">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label-md mb-2" for="case_tag">เลือกฝ่าย</label>
                <select id="case_tag" name="case_tag" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                    <option value="IT">ฝ่ายไอที</option>
                    <option value="MT">ฝ่ายอาคาร</option>

                </select>
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
    </form>
    <hr class="mt-4">
    <div class="col-12 text-center">
        <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal"><i
                class='menu-icon tf-icons bx bx-reset'></i> ล้างฟอร์ม</button>

        <button type="submit" name="saveManager" id="saveManager" class="btn btn-info btn-form-block-overlay"><i
                class='menu-icon tf-icons bx bxs-paper-plane'></i> บันทึกข้อมูล</button>
    </div>

</div>
