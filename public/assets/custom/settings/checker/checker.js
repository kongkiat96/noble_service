var setURLSetting = '/settings-system'
var setURLChecker = setURLSetting + '/checker'

$(function () {
    var dt_Checker = $('.dt-checker')
    dt_Checker.DataTable({
        processing: true,
        paging: true,
        pageLength: 10,
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
            url: setURLChecker + "/get-data-checker",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": $("#show_use_tag").val(),
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
                data: 'checker_name', 
                class: "text-center",
            },
            {
                data: "use_tag",
                orderable: true,
                class: "text-center",
                render: renderStatusWorkBadge
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
                    return renderGroupActionButtonsPermission(data, type, row, 'Checker', Permission);
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

$(document).ready(function () {
    $('#addChecker').click(function () {
        showModalWithAjax('#addCheckerModal', setURLChecker + '/add-checker-modal', ['#use_tag', '#status_tag']);
    });
});

function reTable() {
    $('.dt-checker').DataTable().ajax.reload();
}

function funcEditChecker(checkID) {
    showModalWithAjax('#editCheckerModal', setURLChecker + '/show-edit-checker/' + checkID, ['#use_tag', '#status_tag']);
}

function funcDeleteChecker(checkerID) {
    handleAjaxDeleteResponse(checkerID, setURLChecker + "/delete-checker/" + checkerID);
}

function setupFormValidationChecker(formElement) {

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
        checker_name: validators.notEmptyAndRegexp('ระบุชื่อ ชื่อผู้ตรวจเช็ค / ซ่อม', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        use_tag: validators.notEmpty('เลือกข้อมูล ฝ่ายที่ใช้งาน'),
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