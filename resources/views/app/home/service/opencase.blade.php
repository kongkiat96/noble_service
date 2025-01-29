<div class="row g-1 form-block">
    <form id="formOpenCaseService">
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="use_tag">ฝ่ายที่ต้องการแจ้งปัญหา <span class="text-danger">*</span></label>
                <select id="use_tag" name="use_tag" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                    <option value="IT">ฝ่ายไอที</option>
                    <option value="MT">ฝ่ายช่าง</option>

                </select>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="category_main">รายการกลุ่มอุปกรณ์ <span class="text-danger">*</span></label>
                <select id="category_main" name="category_main" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="category_type">รายการประเภทหมวดหมู่ <span class="text-danger">*</span></label>
                <select id="category_type" name="category_type" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="category_detail">อาการที่ต้องการแจ้งปัญหา <span class="text-danger">*</span></label>
                <select id="category_detail" name="category_detail" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="asset_number">หมายเลขครุภัณฑ์</label>
                <input type="text" id="asset_number" class="form-control" name="asset_number">
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2 text-danger" for="employee_other_case">กรณีแจ้งแทนผู้อื่น</label>
                <select id="employee_other_case" name="employee_other_case" class="form-select select2"
                    data-allow-clear="true">
                    <option value="">Select</option>
                    @foreach ($dataAllEmployee as $key => $value)
                        @if ($value->ID != Auth::user()->map_employee)
                            <option value="{{ $value->ID }}">{{ $value->full_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label-md mb-2" for="manager_name">ผู้อนุมัติงานแจ้งปัญหา</label>
                <input type="text" id="manager_name" class="form-control" name="manager_name"
                    value="{{ @$dataManager->full_name_manager }}" readonly>
            </div>
            <div class="col-md-12 mb-2">
                <label class="form-label-md mb-2" for="case_detail">รายละเอียด <span class="text-danger">*</span></label>
                <textarea id="case_detail" name="case_detail" rows="3" class="form-control"></textarea>
            </div>
            <div class="divider">
                <div class="divider-text font-weight-bold font-size-lg">อัพโหลดรูปภาพ</div>
            </div>
            <input type="text" name="manager_emp_id" id="manager_emp_id" value="{{ @$dataManager->manager_emp_id }}"
                hidden>
            <input type="text" name="sub_emp_id" id="sub_emp_id" value="{{ @$dataManager->sub_emp_id }}" hidden>
        </div>
    </form>
    <div class="col-12 text-center">
        <form action="/upload" class="dropzone needsclick" id="pic-case">
            <div class="dz-message needsclick">
                อัพโหลดรูปภาพในการแจ้งปัญหา
                <span class="note needsclick">(สามารถแนบได้สูงสุด 5 รูป)</span>
            </div>
            <div class="fallback">
                <input name="file" id="pic-case" type="file" />
            </div>
        </form>
    </div>
    <hr class="mt-4">
    <div class="col-12 text-center">
        <button type="button" class="btn btn-label-danger" id="resetFormOpenCaseService"><i class='menu-icon tf-icons bx bx-reset'></i>
            ล้างฟอร์ม</button>

        <button type="submit" name="openCaseService" id="openCaseService"
            class="btn btn-info btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-paper-plane'></i>
            แจ้งปัญหา</button>
    </div>

    <input type="text" name="empID" id="empID" data-empid="{{ Auth::user()->map_employee }}" hidden>


</div>
@section('script')
    <script src="{{ asset('/assets/custom/service/opencase.js?v=') }}@php echo date("H:i:s") @endphp"></script>
    <script src="{{ asset('/assets/custom/service/caseServiceHome.js?v=') }}@php echo date("H:i:s") @endphp"></script>

    <script>
        mapCategoryUseTag('#category_main', '#use_tag', true)
        mapSelectedCategory('#category_type', '#category_main', true)
        mapSelectedCategoryDetail('#category_detail', '#category_type', true)
        AddPicMultiple('#pic-case');
        const textarea = document.querySelectorAll('textarea')
        if (textarea) {
            autosize(textarea);
        }
    </script>
@endsection
