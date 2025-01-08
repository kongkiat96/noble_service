'use strict';
$(function () {
    var dt_status_table = $('.dt-settingStatus')
    dt_status_table.DataTable({
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
            url: '/settings-system/work-status/table-status',
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
                data: 'status_name', 
                class: "text-center",
                render: function(data, type, row) {
                    const color = row.status_color || '#FFFFFF'; // กำหนดสีเริ่มต้นหากไม่มีค่า
                    return renderColorTagBadge(color, data);
                }
            },
            {
                data: "status_use",
                orderable: true,
                class: "text-center",
                render: renderStatusWorkBadge
            },
            {
                data: "status_show",
                orderable: true,
                class: "text-center",
                render: renderStatusShowBadge
            },
            { data: 'group_status', class: "text-center" },
            {
                data: "status",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },

            { data: 'created_at', class: "text-center" },
            { data: 'created_user', class: "text-center" },
            { data: 'update_at', class: "text-center" },
            { data: 'update_user', class: "text-center" },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'Status', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    // var dt_flay_type_table = $('.dt-settingFlagType')
    // if (dt_flay_type_table.length) {
    //     dt_flay_type_table.DataTable({
    //         serverSide: true,
    //         searching: true,
    //         processing: true,
    //         ajax: {
    //             url: '/settings-system/work-status/table-flag-type'
    //         },
    //         columns: [
    //             { data: null, orderable: false, searchable: false, class: "text-center" },
    //             { data: "flag_name", class: "text-nowrap" },
    //             { data: "type_work", class: "text-nowrap", render: renderStatusWorkTypeBadge },
    //             {
    //                 data: 'id',
    //                 orderable: false,
    //                 searchable: false,
    //                 class: "text-center",
    //                 render: (data, type, row) => renderGroupActionButtons(data, type, row, 'FlagType')
    //             }
    //         ],
    //         fnCreatedRow: (nRow, aData, iDisplayIndex) => {
    //             $('td:first', nRow).text(iDisplayIndex + 1);
    //         },
    //         pagingType: 'full_numbers',
    //         drawCallback: function (settings) {
    //             const dataTableApi = this.api();
    //             const startIndexOfPage = dataTableApi.page.info().start;
    //             dataTableApi.column(0).nodes().each((cell, index) => {
    //                 cell.textContent = startIndexOfPage + index + 1;
    //             });
    //         },
    //         order: [[1, "desc"]],
    //         dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    //         displayLength: 50,
    //         lengthMenu: [50, 75, 100]
    //     });
    // }

    var dt_GroupStatus = $('.dt-settingGroupStatus')
    dt_GroupStatus.DataTable({
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
            url: '/settings-system/work-status/table-group-status',
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
                data: 'group_status_th',
                class: "text-center",
            },
            {
                data: 'group_status_en',
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
                    return renderGroupActionButtonsPermission(data, type, row, 'GroupStatus', Permission);
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

function reTable() {
    $('.dt-settingStatus').DataTable().ajax.reload();
    $('.dt-settingFlagType').DataTable().ajax.reload();
    $('.dt-settingGroupStatus').DataTable().ajax.reload();
}

$(document).ready(function () {
    $('#addStatus').click(function () {
        showModalWithAjax('#addStatusModal', '/settings-system/work-status/status-modal', ['#status_use', '#status_show','#group_status', '#status']);
    });

    $('#addFlagType').click(function () {
        showModalWithAjax('#addFlagTypeModal', '/settings-system/work-status/flag-type-modal',['#typeWork']);
    })

    $('#addGroupStatus').click(function () {
        showModalWithAjax('#addGroupStatusModal', '/settings-system/work-status/group-status-modal',['#status_tag']);
    })
});

function funcEditStatus(statusID) {
    showModalWithAjax('#editStatusModal', '/settings-system/work-status/show-edit-status/' + statusID, ['#status_use', '#status_show','#group_status', '#status']);
}

function funcDeleteStatus(statusID) {
    handleAjaxDeleteResponse(statusID, "/settings-system/work-status/delete-status/" + statusID);
}

function funcEditFlagType(flagTypeID) {
    showModalWithAjax('#editFlagTypeModal', '/settings-system/work-status/show-edit-flag-type/' + flagTypeID, ['#edit_typeWork']);
}

function funcDeleteFlagType(flagTypeID) {
    handleAjaxDeleteResponse(flagTypeID, "/settings-system/work-status/delete-flag-type/" + flagTypeID);
}

function funcEditGroupStatus(groupStatisID) {
    showModalWithAjax('#editGroupStatusModal', '/settings-system/work-status/show-edit-group-status/' + groupStatisID, ['#status_tag']);
}

function funcDeleteGroupStatus(groupStatisID) {
    handleAjaxDeleteResponse(groupStatisID, "/settings-system/work-status/delete-group-status/" + groupStatisID);
}

function setupFormValidationGroupStatus(formElement) {
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
        group_status_th: validators.notEmptyAndRegexp('ระบุชื่อ กลุ่มสถานะ (ภาษาไทย)', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        group_status_en: validators.notEmptyAndRegexp('ระบุชื่อ กลุ่มสถานะ (ภาษาอังกฤษ)', /^[a-zA-Z\s]+$/),
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

function setupFormValidationStatus(formElement){
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
        colorFormat: message => ({
            validators: {
                notEmpty: { message },
                regexp: {
                    regexp: /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/,
                    message: 'กรุณาระบุสีในรูปแบบ #RRGGBB หรือ #RGB'
                }
            }
        })
    };

    const validationRules = {
        status_name: validators.notEmptyAndRegexp('ระบุชื่อ รายการสินทรัพย์', /^[a-zA-Z0-9ก-๏\s]+$/u),
        status_color: validators.colorFormat('ระบุค่าสีที่ถูกต้อง'),
        status_use: validators.notEmpty('เลือกข้อมูล การใช้งานสำหรับฝ่าย'),
        status_show: validators.notEmpty('เลือกข้อมูล การแสดงผลสถานะ'),
        group_status: validators.notEmpty('เลือกข้อมูล กลุ่มสถานะ'),
        status: validators.notEmpty('เลือกข้อมูล สถานะการใช้งาน'),
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

