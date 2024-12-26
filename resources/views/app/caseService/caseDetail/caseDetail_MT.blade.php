<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายละเอียดการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#case-action"
                aria-controls="#case-action" aria-selected="true">
                บันทึกข้อมูลการดำเนินงาน
            </button>
        </li>

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
            <div class="row g-1 form-block">
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="ticket">Ticket</label>
                    <input type="text" id="ticket" class="form-control" name="ticket"
                        value="{{ $data['ticket'] }}" readonly autofocus>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_main_name">รายการกลุ่มอุปกรณ์</label>
                    <input type="text" id="category_main_name" class="form-control" name="category_main_name"
                        value="{{ $data['category_main_name'] }}" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_type_name">รายการประเภทหมวดหมู่</label>
                    <input type="text" id="category_type_name" class="form-control" name="category_type_name"
                        value="{{ $data['category_type_name'] }}" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label-md mb-2" for="category_detail_name">อาการที่ต้องการแจ้งปัญหา</label>
                    <input type="text" id="category_detail_name" class="form-control" name="category_detail_name"
                        value="{{ $data['category_detail_name'] }}" readonly>
                </div>
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
                            <input type="text" id="sla" class="form-control" name="sla" readonly value="{{ $data['sla'] }}">
                        </div>
                        <div class="col-md-9 mb-4">
                            <label class="form-label-md mb-2" for="case_price">ค่าใช้จ่าย</label>
                            {{-- <input type="text" id="case_price" class="form-control" name="case_price"
                                value=""> --}}

                            <div class="input-group">
                                <input type="text" class="form-control numeral-mask text-end"
                                    placeholder="ค่าใช้จ่าย" name="case_price" id="case_price"
                                    oninput="formatAmount(this)" value="{{ $data['price'] }}"/>
                                <span class="input-group-text">฿</span>
                            </div>



                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="worker" class="form-label-md mb-2">ผู้ปฏิบัติงาน</label>
                            <input id="worker" name="worker" class="form-control"
                                placeholder="&nbsp เลือกผู้ปฏิบัติงาน" value="{{ $workerNames }}" />
                            {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label-md mb-2" for="case_doing_detail">รายละเอียดการทำงาน <span
                                    class="text-danger">*</span></label>
                            <textarea id="case_doing_detail" name="case_doing_detail" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="divider">
                            <div class="divider-text font-weight-bold font-size-lg">สถานะการทำงาน</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label-md mb-2" for="case_status">สถานะการการทำงาน <span
                                    class="text-danger">*</span></label>
                            <select name="case_status" id="case_status" class="form-select select2"
                                data-allow-clear="true">
                                <option value=""></option>
                                @foreach ($getStatusWork as $key)
                                    <option value="{{ $key->ID }}">{{ $key->status_name }}</option>
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
                    {{-- <button type="button" class="btn btn-label-danger"><i
                            class='menu-icon tf-icons bx bx-reset' id="resetFormApproveManager"></i>
                        ล้างฟอร์ม</button> --}}
                    <button type="submit" name="saveCaseAction" id="saveCaseAction"
                        class="btn btn-success btn-form-block-overlay"><i class='menu-icon tf-icons bx bxs-save'></i>
                        บันทึกข้อมูลดำเนินงาน</button>
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
                                        <img class="card-img-top img-fluid w-150 h-150"
                                            src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            alt="{{ $value->file_name }}" />
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
                                        <img class="card-img-top img-fluid w-150 h-150"
                                            src="{{ asset('storage/uploads/caseService/' . $value->file_name) }}"
                                            alt="{{ $value->file_name }}" />
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
<script type="text/javascript" src="{{ asset('/assets/custom/caseService/caseAction.js?v=') }}@php echo date("H:i:s") @endphp"></script>
<script type="text/javascript">

        mapSelectedCategoryItem('#case_list', '#case_item', true)
    AddPicMultiple('#pic-case');
    (function() {
        // Users List suggestion
        //------------------------------------------------------
        const TagifyUserListEl = document.querySelector('#worker');
        // สร้าง array สำหรับ usersList โดยใช้ข้อมูลจาก $getDataWorker
        const usersList = @json($getDataWorker).map(worker => ({
            value: worker.ID,
            name: worker.employee_name,
            // avatar: worker.img_base ? `data:image/png;base64,${worker.img_base}` : '', // ถ้าภาพเป็น base64
            emp_code: worker.employee_code
        }));

        function tagTemplate(tagData) {
            return `
    <tag title="${tagData.title || tagData.emp_code}"
      contenteditable='false'
      spellcheck='false'
      tabIndex="-1"
      class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}"
      ${this.getAttributes(tagData)}
    >
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

        // initialize Tagify on the above input node reference
        let TagifyUserList = new Tagify(TagifyUserListEl, {
            tagTextProp: 'name', // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: 'users-list',
                searchKeys: ['name',
                    'emp_code'
                ] // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: usersList
        });

        TagifyUserList.on('dropdown:show dropdown:updated', onDropdownShow);
        TagifyUserList.on('dropdown:select', onSelectSuggestion);

        let addAllSuggestionsEl;

        function onDropdownShow(e) {
            let dropdownContentEl = e.detail.tagify.DOM.dropdown.content;

            if (TagifyUserList.suggestedListItems.length > 1) {
                addAllSuggestionsEl = getAddAllSuggestionsEl();

                // insert "addAllSuggestionsEl" as the first element in the suggestions list
                dropdownContentEl.insertBefore(addAllSuggestionsEl, dropdownContentEl.firstChild);
            }
        }

        function onSelectSuggestion(e) {
            if (e.detail.elm == addAllSuggestionsEl) TagifyUserList.dropdown.selectAll.call(TagifyUserList);
        }

        // create an "add all" custom suggestion element every time the dropdown changes
        function getAddAllSuggestionsEl() {
            // suggestions items should be based on "dropdownItem" template
            return TagifyUserList.parseTemplate('dropdownItem', [{
                class: 'addAll',
                name: 'เลือกทั้งหมด',
                emp_code: TagifyUserList.settings.whitelist.reduce(function(remainingSuggestions,
                item) {
                    return TagifyUserList.isTagDuplicate(item.value) ? remainingSuggestions :
                        remainingSuggestions + 1;
                }, 0) + ' รายการ'
            }]);
        }
    })();
</script>
