<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#detail-case"
                aria-controls="#detail-case" aria-selected="true">
                รายละเอียดการแจ้งปัญหา
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#detail-pic"
                aria-controls="#detail-pic" aria-selected="true">
                รูปภาพการแจ้งปัญหา
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
                <div class="row">
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
                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">ข้อมูลรายการแก้ไขปัญหา</div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_main_name">รายการที่เสีย</label>
                        <input type="text" id="category_main_name" class="form-control" name="category_main_name"
                            value="{{ $data['category_main_name'] }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label-md mb-2" for="category_type_name">รายการที่แก้ไขปัญหา</label>
                        <input type="text" id="category_type_name" class="form-control" name="category_type_name"
                            value="{{ $data['category_type_name'] }}" readonly>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label-md mb-2" for="sla">SLA</label>
                        <input type="text" id="sla" class="form-control" name="sla"
                            value="{{ $data['asset_number'] }}" readonly>
                    </div>
                    <div class="col-md-9 mb-2">
                        <label for="selectWorker" class="form-label-md mb-2">ผู้ปฏิบัติงาน</label>
                        <input id="selectWorker" name="selectWorker" class="form-control" placeholder="&nbsp ผู้ปฏิบัติงาน" value="" />
                            {{-- value="abatisse2@nih.gov, Justinian Hattersley" /> --}}
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label-md mb-2" for="case_approve_detail">รายละเอียดการทำงาน</label>
                        <textarea id="case_approve_detail" name="case_approve_detail" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="divider">
                        <div class="divider-text font-weight-bold font-size-lg">บันทึกสถานะการทำงาน</div>
                    </div>
                </div>
                <form id="formApproveToPadding">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label-md mb-2" for="case_status">สถานะการการทำงาน</label>
                            <select name="case_status" id="case_status" class="form-select select2"
                                data-allow-clear="true">
                                <option value=""></option>

                            </select>
                        </div>

                    </div>


                    <input type="text" name="caseID" id="caseID" value="{{ $data['id'] }}" hidden>
                </form>
                <hr class="mt-4">
                <div class="col-12 text-center">
                    {{-- <button type="button" class="btn btn-label-danger"><i
                            class='menu-icon tf-icons bx bx-reset' id="resetFormApproveManager"></i>
                        ล้างฟอร์ม</button> --}}

                    <button type="submit" name="approveCaseToPadding" id="approveCaseToPadding"
                        class="btn btn-warning btn-form-block-overlay"><i
                            class='menu-icon tf-icons bx bxs-paper-plane'></i>
                        อนุมัติดำเนินการ</button>
                </div>


            </div>
        </div>

        <div class="tab-pane fade" id="detail-pic" role="tabpanel">
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
        <input type="text" value="{{ $data['id'] }}" name="caseID" id="caseID" hidden>
    </div>
</div>
<script type="text/javascript">
    (function() {
        // Users List suggestion
        //------------------------------------------------------
        const TagifyUserListEl = document.querySelector('#selectWorker');

        const usersList = [{
                value: 1,
                name: 'Justinian Hattersley',
                avatar: 'https://i.pravatar.cc/80?img=1',
                email: 'jhattersley0@ucsd.edu'
            },
            {
                value: 2,
                name: 'Antons Esson',
                avatar: 'https://i.pravatar.cc/80?img=2',
                email: 'aesson1@ning.com'
            },
            {
                value: 3,
                name: 'Ardeen Batisse',
                avatar: 'https://i.pravatar.cc/80?img=3',
                email: 'abatisse2@nih.gov'
            },
            {
                value: 4,
                name: 'Graeme Yellowley',
                avatar: 'https://i.pravatar.cc/80?img=4',
                email: 'gyellowley3@behance.net'
            },
            {
                value: 5,
                name: 'Dido Wilford',
                avatar: 'https://i.pravatar.cc/80?img=5',
                email: 'dwilford4@jugem.jp'
            },
            {
                value: 6,
                name: 'Celesta Orwin',
                avatar: 'https://i.pravatar.cc/80?img=6',
                email: 'corwin5@meetup.com'
            },
            {
                value: 7,
                name: 'Sally Main',
                avatar: 'https://i.pravatar.cc/80?img=7',
                email: 'smain6@techcrunch.com'
            },
            {
                value: 8,
                name: 'Grethel Haysman',
                avatar: 'https://i.pravatar.cc/80?img=8',
                email: 'ghaysman7@mashable.com'
            },
            {
                value: 9,
                name: 'Marvin Mandrake',
                avatar: 'https://i.pravatar.cc/80?img=9',
                email: 'mmandrake8@sourceforge.net'
            },
            {
                value: 10,
                name: 'Corrie Tidey',
                avatar: 'https://i.pravatar.cc/80?img=10',
                email: 'ctidey9@youtube.com'
            }
        ];

        function tagTemplate(tagData) {
            return `
    <tag title="${tagData.title || tagData.email}"
      contenteditable='false'
      spellcheck='false'
      tabIndex="-1"
      class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ''}"
      ${this.getAttributes(tagData)}
    >
      <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
      <div>
        <div class='tagify__tag__avatar-wrap'>
          <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
        </div>
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
      ${
        tagData.avatar
          ? `<div class='tagify__dropdown__item__avatar-wrap'>
          <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
        </div>`
          : ''
      }
      <strong>${tagData.name}</strong>
      <span>${tagData.email}</span>
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
                    'email'] // very important to set by which keys to search for suggesttions when typing
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
                email: TagifyUserList.settings.whitelist.reduce(function(remainingSuggestions, item) {
                    return TagifyUserList.isTagDuplicate(item.value) ? remainingSuggestions :
                        remainingSuggestions + 1;
                }, 0) + ' รายการ'
            }]);
        }
    })();
</script>
