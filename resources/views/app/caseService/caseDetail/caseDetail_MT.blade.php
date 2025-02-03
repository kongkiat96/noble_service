<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายละเอียดการแจ้งปัญหา
            </button>
        </li>
        @if ($data['tag_work'] != 'wait_manager_mt_approve')
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#case-action" aria-controls="#case-action" aria-selected="true">
                    บันทึกข้อมูลการดำเนินงาน
                </button>
            </li>
        @endif

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-pic"
                aria-controls="#detail-pic" aria-selected="true">
                รายการรูปภาพ
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-history"
                aria-controls="#detail-history" aria-selected="true" id="reTabA">
                ประวัติการบันทึกข้อมูล
            </button>
        </li>

    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="detail-case" role="tabpanel">
            <div class="row mb-2 text-end">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <button type="submit" name="printWork" id="printWork"
                        class="btn btn-danger btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-file-pdf'></i>
                        พิมพ์ใบงาน</button>
                </div>
                <input type="text" name="caseTicket" id="caseTicket" value="{{ $data['ticket'] }}" hidden>
            </div>
            @if (!empty($data['sla']))
                <form>
                    <div class="row">
                        <div class="divider mt-0">
                            <div class="divider-text font-weight-bold">ข้อมูลระยะเวลาดำเนินงาน</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-md mb-2" for="case_start">วันที่แจ้งงาน</label>
                            <input type="text" id="case_start" class="form-control" name="case_start" readonly
                                value="{{ $data['case_start'] }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-md mb-2" for="case_end">วันที่ดำเนินงานต้องแล้วเสร็จ</label>
                            <input type="text" id="case_end" class="form-control" name="case_end" readonly
                                value="{{ $data['calSLANullCaseEnd']['end_time'] }}">
                            @if (\Carbon\Carbon::now() > $data['calSLANullCaseEnd']['end_time'])
                                <label class="form-label-sm mt-2 text-danger"
                                    for="case_end">ขณะนี้เกินระยะเวลาที่กำหนด</label>
                            @else
                                <label class="form-label-sm mt-2 text-warning" for="case_end">ขณะนี้เหลือเวลาอีก
                                    {{ $data['calSLANullCaseEnd']['time_remaining'] }}</label>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="divider mt-0">
                    <div class="divider-text font-weight-bold">ข้อมูลการแจ้งปัญหา</div>
                </div>
            @endif
            <form id="formChangeCategory">
                <div class="row g-1 form-block">
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="ticket">Ticket</label>
                        <input type="text" id="ticket" class="form-control" name="ticket"
                            value="{{ $data['ticket'] }}" readonly autofocus>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_main">รายการกลุ่มอุปกรณ์</label>
                        <select class="form-select select2" name="category_main" id="category_main"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryMain as $key => $value)
                                <option value="{{ $value->id }}" @if ($data['category_main'] == $value->id) selected @endif>
                                    {{ $value->category_main_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_type">รายการประเภทหมวดหมู่</label>
                        <select class="form-select select2" name="category_type" id="category_type"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryType as $key => $value)
                                <option value="{{ $value->id }}" @if ($data['category_type'] == $value->id) selected @endif>
                                    {{ $value->category_type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_detail">อาการที่ต้องการแจ้งปัญหา</label>
                        <select class="form-select select2" name="category_detail" id="category_detail"
                            data-allow-clear="true">
                            <option value="">Select</option>
                            @foreach ($dataCategoryDetail as $key => $value)
                                <option value="{{ $value->id }}" @if ($data['category_detail'] == $value->id) selected @endif>
                                    {{ $value->category_detail_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="category_type_old" id="category_type_old"
                        value="{{ $data['category_type'] }}" hidden>
                    <input type="text" name="category_detail_old" id="category_detail_old"
                        value="{{ $data['category_detail'] }}" hidden>
                    <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="asset_number">หมายเลขครุภัณฑ์</label>
                        <input type="text" id="asset_number" class="form-control" name="asset_number"
                            value="{{ $data['asset_number'] }}" readonly>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="employee_other_case_name">ผู้แจ้งปัญหา</label>
                        <input type="text" id="employee_other_case_name" class="form-control"
                            name="employee_other_case_name" value="{{ $data['employee_other_case_name'] }}" readonly>
                    </div>
                    @if ($data['manager_name'] != null)
                        <div class="col-md-12 mb-4">
                            <label class="form-label-md mb-2" for="manager_name">ผู้บังคับบัญชา</label>
                            <input type="text" id="manager_name" class="form-control" name="manager_name"
                                value="{{ $data['manager_name'] }}" readonly>
                        </div>
                    @endif
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_detail">รายละเอียด</label>
                        <textarea id="case_detail" name="case_detail" rows="3" class="form-control" readonly>{{ $data['case_detail'] }}</textarea>
                    </div>
                </div>
            </form>
            <div class="col-12 text-center">
                {{-- set case status getDataStatusWork --}}
                @if (in_array($data['group_status'], ['Success','success']))
                    <div class="alert alert-warning text-bold" role="alert">
                        รายการนี้อยู่ระหว่างตรวจสอบงาน
                    </div>
                @else
                    <button type="submit" name="changeCategory" id="changeCategory"
                        class="btn btn-warning btn-form-block-overlay"><i
                            class='menu-icon tf-icons bx bx-git-compare'></i>
                        เปลี่ยนแปลงข้อมูลการแจ้ง</button>
                @endif
            </div>
        </div>

        <div class="tab-pane fade" id="case-action" role="tabpanel">
            <div class="row g-1 form-block">
                <form id="formDoingCaseAction">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label-md mb-2" for="case_item">รายการที่เสีย <span
                                    class="text-danger">*</span></label>
                            <select id="case_item" name="case_item" class="form-control select2"
                                data-allow-clear="true">
                                <option value="">เลือกรายการ</option>
                                @foreach ($categoryItem as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($data['case_item'] == $item->id) selected @endif>
                                        {{ $item->category_item_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-md mb-2" for="case_list">รายการที่แก้ไขปัญหา <span
                                    class="text-danger">*</span></label>
                            <select id="case_list" name="case_list" class="form-control select2"
                                data-allow-clear="true">
                                <option value="">เลือกรายการ</option>
                                @foreach ($categoryList as $list)
                                    <option value="{{ $list->id }}"
                                        @if ($data['case_list'] == $list->id) selected @endif>
                                        {{ $list->category_list_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label-md mb-2" for="sla">SLA</label>
                            <input type="text" id="sla" class="form-control" name="sla" readonly
                                value="{{ $data['sla'] }}">
                        </div>
                        <div class="col-md-9 mb-4">
                            <label class="form-label-md mb-2" for="case_price">ค่าใช้จ่าย</label>
                            {{-- <input type="text" id="case_price" class="form-control" name="case_price"
                                value=""> --}}

                            <div class="input-group">
                                <input type="text" class="form-control numeral-mask text-end"
                                    placeholder="ค่าใช้จ่าย" name="case_price" id="case_price"
                                    oninput="formatAmount(this)" value="{{ $data['price'] }}" />
                                <span class="input-group-text">฿</span>
                            </div>



                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="worker" class="form-label-md mb-2">ช่างผู้ปฏิบัติงาน / รับผิดชอบ</label>
                            <input id="worker" name="worker" class="form-control"
                                placeholder="&nbsp ช่างผู้ปฏิบัติงาน / รับผิดชอบ" value="{{ $workerNames }}" />
                            {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="checker" class="form-label-md mb-2">ผู้รับเหมา / ซัพนอก</label>
                            <input id="checker" name="checker" class="form-control"
                                placeholder="&nbsp ผู้รับเหมา / ซัพนอก" value="{{ $checkerNames }}" />
                            {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label-md mb-2" for="case_doing_detail">รายละเอียดการทำงาน <span
                                    class="text-danger">*</span></label>
                            <textarea id="case_doing_detail" name="case_doing_detail" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="divider">
                            <div class="divider-text font-weight-bold font-size-lg">สถานะการทำงาน</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label-md mb-2" for="case_status">สถานะการทำงาน <span
                                    class="text-danger">*</span></label>
                            <select name="case_status" id="case_status" class="form-select select2"
                                data-allow-clear="true">
                                <option value=""></option>
                                @foreach ($getStatusWork as $key)
                                    {{-- @if (!in_array($key->ID, [99999])) --}}
                                    <option value="{{ $key->ID }}"
                                        @if ($data['case_status'] == $key->ID) selected @endif>{{ $key->status_name }}
                                    </option>
                                    {{-- @endif --}}
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>

                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">รูปภาพการแก้ไขปัญหา</div>
                    </div>
                </form>
                {{-- <div class="row"> --}}
                <div class="col-12 text-center">
                    <form action="/upload" class="dropzone needsclick" id="pic-case">
                        <div class="dz-message needsclick">
                            อัพโหลดรูปภาพในการแก้ไขปัญหา
                            <span class="note needsclick">(สามารถแนบได้สูงสุด 5 รูป)</span>
                        </div>
                        <div class="fallback">
                            <input name="file" id="pic-case" type="file" />
                        </div>
                    </form>
                </div>
                {{-- </div> --}}

                <hr class="mt-4">
                <div class="col-12 text-center">
                    {{-- set case status getDataStatusWork --}}
                    @if (in_array($data['group_status'], ['Success','success']))
                        <div class="alert alert-warning text-bold" role="alert">
                            รายการนี้อยู่ระหว่างตรวจสอบงาน
                        </div>
                    @else
                        <button type="submit" name="saveCaseAction" id="saveCaseAction"
                            class="btn btn-success btn-form-block-overlay"><i
                                class='menu-icon tf-icons bx bxs-save'></i>
                            บันทึกข้อมูล</button>
                    @endif
                </div>


            </div>
        </div>

        <div class="tab-pane fade" id="detail-pic" role="tabpanel">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#before-pic" aria-controls="#before-pic" aria-selected="true">
                        ก่อนแก้ไขปัญหา
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#after-pic" aria-controls="#after-pic" aria-selected="true">
                        หลังแก้ไขปัญหา <span class="text-danger">(แสดง 5 รายการล่าสุด)</span>
                    </button>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="before-pic" role="tabpanel">
                    <div class="row g-1 form-block">
                        @if (!empty($image))
                            @foreach ($image as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <!-- กดที่ภาพเพื่อเปิด Modal -->
                                        <img class="card-img-top img-fluid w-150 h-150" style="cursor: pointer;"
                                            src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            alt="{{ $value->file_name }}" data-bs-toggle="modal"
                                            data-bs-target="#imageModal{{ $key }}" />
                                    </div>
                                </div>
                                <div class="modal fade" id="imageModal{{ $key }}"
                                    aria-labelledby="imageModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                                    class="img-fluid" alt="{{ $value->file_name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            ไม่พบข้อมูลรูปภาพ
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="after-pic" role="tabpanel">
                    <div class="row g-1 form-block">
                        @if (!empty($imageDoing))
                            @foreach ($imageDoing as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <!-- กดที่ภาพเพื่อเปิด Modal -->
                                        <img class="card-img-top img-fluid w-150 h-150" style="cursor: pointer;"
                                            src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            alt="{{ $value->file_name }}" data-bs-toggle="modal"
                                            data-bs-target="#imageModal_after{{ $key }}" />
                                    </div>
                                </div>
                                <div class="modal fade" id="imageModal_after{{ $key }}"
                                    aria-labelledby="imageModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                                    class="img-fluid" alt="{{ $value->file_name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            ไม่พบข้อมูลรูปภาพ
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="detail-history" role="tabpanel">
            {{-- <div class="row g-1 form-block"> --}}
            <div class="text-nowrap table-responsive">
                <table class="dt-approve-history table table-bordered table-hover table-striped" style="width: 100%">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>สถานะ</th>
                            <th class="text-center">รายละเอียด</th>
                            <th>ค่าใช้จ่าย</th>
                            <th>วัน / เวลาที่บันทึกข้อมูล</th>
                            <th>ผู้บันทึกข้อมูล</th>
                        </tr>
                    </thead>
                </table>
            </div>
            {{-- </div> --}}


        </div>
    </div>
</div>
<script type="text/javascript"
    src="{{ asset('/assets/custom/caseService/caseAction.js?v=') }}@php echo date("H:i:s") @endphp"></script>
<script type="text/javascript">
    mapSelectedCategoryItem('#case_list', '#case_item', true)
    AddPicMultiple('#pic-case');

    (function() {
        // ดึงข้อมูลจาก API หรือ View
        const TagifyWorkerEl = document.querySelector('#worker');
        const TagifyCheckerEl = document.querySelector('#checker');

        const workerList = @json($getDataWorker).map(worker => ({
            value: worker.ID,
            name: worker.employee_name,
            emp_code: worker.employee_code
        }));

        const checkerList = @json($getDataChecker).map(checker => ({
            value: checker.id,
            name: checker.checker_name,
            emp_code: ' '
        }));

        // รวมข้อมูล Worker และ Checker
        const combinedList = [workerList, checkerList];

        function tagTemplate(tagData) {
            return `
            <tag title="${tagData.title || tagData.emp_code}" contenteditable='false' spellcheck='false' tabIndex="-1" class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}" ${this.getAttributes(tagData)}>
                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                <div>
                    <span class='tagify__tag-text'>${tagData.name}</span>
                </div>
            </tag>
        `;
        }

        function suggestionItemTemplate(tagData) {
            return `
            <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item align-items-center ${tagData.class ? tagData.class : ''}'
            tabindex="0"
            role="option"
            >
                <strong>${tagData.name}</strong>
                <span>${tagData.emp_code}</span>
            </div>
        `;
        }

        function initializeTagify(element, list) {
            if (!element) return;

            let tagifyInstance = new Tagify(element, {
                tagTextProp: 'name',
                enforceWhitelist: true,
                skipInvalid: true,
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name', 'emp_code']
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: list
            });

            tagifyInstance.on('dropdown:show dropdown:updated', onDropdownShow);
            tagifyInstance.on('dropdown:select', onSelectSuggestion);

            let addAllSuggestionsEl;

            function onDropdownShow(e) {
                let dropdownContentEl = e.detail.tagify.DOM.dropdown.content;

                if (tagifyInstance.suggestedListItems.length > 1) {
                    addAllSuggestionsEl = getAddAllSuggestionsEl();

                    // insert "addAllSuggestionsEl" as the first element in the suggestions list
                    dropdownContentEl.insertBefore(addAllSuggestionsEl, dropdownContentEl.firstChild);
                }
            }

            function onSelectSuggestion(e) {
                if (e.detail.elm == addAllSuggestionsEl) tagifyInstance.dropdown.selectAll.call(tagifyInstance);
            }

            function getAddAllSuggestionsEl() {
                return tagifyInstance.parseTemplate('dropdownItem', [{
                    class: 'addAll',
                    name: 'เลือกทั้งหมด',
                    emp_code: tagifyInstance.settings.whitelist.reduce(function(remainingSuggestions,
                        item) {
                        return tagifyInstance.isTagDuplicate(item.value) ?
                            remainingSuggestions :
                            remainingSuggestions + 1;
                    }, 0) + ' รายการ'
                }]);
            }
        }

        // สร้าง Tagify สำหรับ Worker และ Checker
        initializeTagify(TagifyWorkerEl, workerList);
        initializeTagify(TagifyCheckerEl, checkerList);
    })();
</script>
<script>
    mapSelectedCategory('#category_type', '#category_main', true)
    mapSelectedCategoryDetail('#category_detail', '#category_type', true)
</script>
