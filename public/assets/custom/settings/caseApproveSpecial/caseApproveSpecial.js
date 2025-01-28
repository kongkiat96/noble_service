var setURLCaseApprove = '/settings-system/case-approve-special';

$(function () {
    var dt_CaseApproveCCTV = $('.dt-case-approve-cctv')
    dt_CaseApproveCCTV.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true, // เปลี่ยนเป็น true
        scrollX: true,
        fixedColumns: {
            leftColumns: 2
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        ajax: {
            url: setURLCaseApprove + "/get-data-case-approve-special",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "cctv",
                });
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'category_main_name',
                class: "text-center",
            },
            {
                data: 'category_type_name',
                class: "text-center",
            },
            {
                data: 'category_detail_name',
                class: "text-center",
            },
            {
                data: "use_tag",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusWorkBadge
            },
            {
                data: "status_use",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },
            { data: 'created_at', class: "text-center" },
            { data: 'created_user', class: "text-center" },
            { data: 'updated_at', class: "text-center" },
            { data: 'updated_user', class: "text-center" },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'CaseApprove', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_CaseApprovePermission = $('.dt-case-approve-permission')
    dt_CaseApprovePermission.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true, // เปลี่ยนเป็น true
        scrollX: true,
        fixedColumns: {
            leftColumns: 2
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        ajax: {
            url: setURLCaseApprove + "/get-data-case-approve-special",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "permission",
                });
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'category_main_name',
                class: "text-center",
            },
            {
                data: 'category_type_name',
                class: "text-center",
            },
            {
                data: 'category_detail_name',
                class: "text-center",
            },
            {
                data: "use_tag",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusWorkBadge
            },
            {
                data: "status_use",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },
            { data: 'created_at', class: "text-center" },
            { data: 'created_user', class: "text-center" },
            { data: 'updated_at', class: "text-center" },
            { data: 'updated_user', class: "text-center" },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'CaseApprove', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });
});


$('#addCaseCCTV').click(function () {
    showModalWithAjax('#addCaseCCTVModal', setURLCaseApprove + '/add-case-cctv-modal', ['#status_use','#category_main', '#category_type','#category_detail']);
});
$('#addCasePermission').click(function () {
    showModalWithAjax('#addCasePermissionModal', setURLCaseApprove + '/add-case-permission-modal', ['#status_use','#category_main_per', '#category_type_per','#category_detail_per']);
});

function setupFormValidationApprove(formElement) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
    };
    const validationRules = {
        category_main: validators.notEmpty('เลือกข้อมูล รายการกลุ่มอุปกรณ์'),
        category_type: validators.notEmpty('เลือกข้อมูล รายการประเภทหมวดหมู่'),
        category_detail: validators.notEmpty('เลือกข้อมูล อาการที่ต้องการแจ้งปัญหา'),
        status_use: validators.notEmpty('เลือกข้อมูล สถานะ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-6'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function funcEditCaseApprove(caseApproveID) {
    // alert(caseApproveID);
    showModalWithAjax('#editCaseApproveModal', setURLCaseApprove + '/show-edit-case-approve/' + caseApproveID, ['#status_use','#category_main_edit', '#category_type_edit','#category_detail_edit']);
}

function funcDeleteCaseApprove(caseApproveID) {
    // alert(caseApproveID);
    handleAjaxDeleteResponse(caseApproveID, setURLCaseApprove + '/delete-case-approve/' + caseApproveID);
}

function reTable() {
    $('.dt-case-approve-cctv').DataTable().ajax.reload(null, false);
    $('.dt-case-approve-permission').DataTable().ajax.reload(null, false);
}