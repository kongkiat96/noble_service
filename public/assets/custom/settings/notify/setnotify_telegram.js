$(function () {
    var dt_NotiTelegram = $('.dt-setting-notify-telegram')
    dt_NotiTelegram.DataTable({
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
            url: "/settings-system/setnotify-telegram/get-data-notify-telegram",
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
            { data: 'token', class: "text-center" },
            { data: 'chat_id', class: "text-center" },
            {
                data: 'alert_type',
                class: "text-center",
                render: function (data, type, row) {
                    // return row.alert_type;
                    if(row.alert_type == "alert_only"){
                    return `<span class="badge bg-label-info">ส่วนตัว</span>`;
                    } else if (row.alert_type == "alert_group") {
                        return `<span class="badge bg-label-primary">กลุ่ม</span>`;
                    } else {
                        return `<span class="badge bg-label-secondary">UNDEFINED</span>`;
                    }
                }
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
            { data: 'created_userid', class: "text-center" },
            { data: 'updated_at', class: "text-center" },
            { data: 'updated_userid', class: "text-center" },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'NotifyTelegram', Permission);
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
    $('#addToken').click(function () {
        showModalWithAjax('#addTokenModal', '/settings-system/setnotify-telegram/add-notify-modal', ['#status_use', '#use_tag']);
    });
});

function reTable() {
    $('.dt-setting-notify-telegram').DataTable().ajax.reload();
}

function funcEditNotifyTelegram(telegramID) {
    // alert(telegramID);
    showModalWithAjax('#editTokenModal', '/settings-system/setnotify-telegram/show-edit-notify-telegram/' + telegramID, ['#status_use', '#use_tag']);
}

function funcDeleteNotifyTelegram(telegramID) {
    // alert(telegramID);
    handleAjaxDeleteResponse(telegramID, '/settings-system/setnotify-telegram/delete-notify-telegram/' + telegramID);
}

function setupFormValidationSetTelegram(formElement) {
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
        token: validators.notEmptyAndRegexp('ระบุ Token ของ Telegram Bot'),
        chat_id: validators.notEmptyAndRegexp('กรุณาตรวจสอบ Chat ID', /^-?[0-9]+$/),
        use_tag: validators.notEmpty('เลือกข้อมูล ฝ่ายที่ใช้งาน'),
        status_use: validators.notEmpty('เลือกข้อมูล สถานะ'),
        alert_type: validators.notEmpty('เลือกข้อมูล สถานะ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-6, .col-md-12'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}