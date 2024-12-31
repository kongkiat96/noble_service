var setURLSetting = '/settings-system'
var setURLBranch = setURLSetting + '/branch'

$(function () {
    var dt_Branch = $('.dt-branch')
    dt_Branch.DataTable({
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
            url: setURLBranch + "/get-data-branch",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'branch_name',
                class: "text-center",
            },
            {
                data: 'branch_code',
                class: "text-center",
            },
            {
                data: "status_tag",
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
                    return renderGroupActionButtonsPermission(data, type, row, 'Branch', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });
})

function reTable() {
    $('.dt-branch').DataTable().ajax.reload();
}

$(document).ready(function () {
    $('#addBranch').click(function () {
        showModalWithAjax('#addBranchModal', setURLBranch + '/add-branch-modal', ['#status_tag']);
    });
});

function funcEditBranch(branchID) {
    showModalWithAjax('#editBranchModal', setURLBranch + '/show-edit-branch/' + branchID, ['#status_tag']);
}

function funcDeleteBranch(branchID) {
    handleAjaxDeleteResponse(branchID, setURLBranch + "/delete-branch/" + branchID);
}


function setupFormValidationBranch(formElement) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
        notEmptyAndRegexp: (message, regexp) => ({
            validators: {
                notEmpty: { message },
                regexp: { regexp, message: 'ข้อมูลไม่ถูกต้อง' }
            }
        }),
    };

    const validationRules = {
        branch_name: validators.notEmptyAndRegexp('ระบุชื่อ สาขา (เต็ม)', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        branch_code: validators.notEmptyAndRegexp('ระบุชื่อ สาขา (ย่อ)', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        status_tag: validators.notEmpty('เลือกข้อมูล สถานะ'),
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