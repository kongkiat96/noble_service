'use strict';
$(function () {
    var dt_status_table = $('.dt-settingStatus')
    var dt_flay_type_table = $('.dt-settingFlagType')
    if (dt_status_table.length) {
        dt_status_table.DataTable({
            serverSide: true,
            searching: true,
            processing: true,
            ajax: {
                url: '/settings-system/work-status/table-status'
            },
            columns: [
                { data: null, orderable: false, searchable: false, class: "text-center" },
                { data: "status_name", class: "text-nowrap" },
                { data: "type_work", class: "text-nowrap", render: renderStatusWorkTypeBadge },
                { data: "status_use", class: "text-nowrap", render: renderStatusWorkBadge },
                {
                    data: "status",
                    orderable: false,
                    searchable: false,
                    class: "text-center",
                    render: renderStatusBadge
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    class: "text-center",
                    render: (data, type, row) => renderGroupActionButtons(data, type, row, 'Status')
                }
            ],
            fnCreatedRow: (nRow, aData, iDisplayIndex) => {
                $('td:first', nRow).text(iDisplayIndex + 1);
            },
            pagingType: 'full_numbers',
            drawCallback: function (settings) {
                const dataTableApi = this.api();
                const startIndexOfPage = dataTableApi.page.info().start;
                dataTableApi.column(0).nodes().each((cell, index) => {
                    cell.textContent = startIndexOfPage + index + 1;
                });
            },
            order: [[1, "desc"]],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 50,
            lengthMenu: [50, 75, 100]
        });
    }

    if (dt_flay_type_table.length) {
        dt_flay_type_table.DataTable({
            serverSide: true,
            searching: true,
            processing: true,
            ajax: {
                url: '/settings-system/work-status/table-flag-type'
            },
            columns: [
                { data: null, orderable: false, searchable: false, class: "text-center" },
                { data: "flag_name", class: "text-nowrap" },
                { data: "type_work", class: "text-nowrap", render: renderStatusWorkTypeBadge },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    class: "text-center",
                    render: (data, type, row) => renderGroupActionButtons(data, type, row, 'FlagType')
                }
            ],
            fnCreatedRow: (nRow, aData, iDisplayIndex) => {
                $('td:first', nRow).text(iDisplayIndex + 1);
            },
            pagingType: 'full_numbers',
            drawCallback: function (settings) {
                const dataTableApi = this.api();
                const startIndexOfPage = dataTableApi.page.info().start;
                dataTableApi.column(0).nodes().each((cell, index) => {
                    cell.textContent = startIndexOfPage + index + 1;
                });
            },
            order: [[1, "desc"]],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 50,
            lengthMenu: [50, 75, 100]
        });
    }

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
            url: setURLWorker + "/get-data-worker",
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
                data: 'full_name',
                class: "text-center",
            },
            {
                data: 'company_name_th',
                class: "text-center",
            },
            {
                data: 'class_name',
                class: "text-center",
            },
            {
                data: 'position_name',
                class: "text-center",
            },
            {
                data: 'department_name',
                class: "text-center",
            },
            {
                data: 'group_name',
                class: "text-center",
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
            {
                data: "use_tag",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusWorkBadge
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
                    return renderGroupActionButtonsPermission(data, type, row, 'Worker', Permission);
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
        showModalWithAjax('#addStatusModal', '/settings-system/work-status/status-modal', ['#statusUse', '#flagType', '#statusOfStatus']);
    });

    $('#addFlagType').click(function () {
        showModalWithAjax('#addFlagTypeModal', '/settings-system/work-status/flag-type-modal',['#typeWork']);
    })

    $('#addGroupStatus').click(function () {
        showModalWithAjax('#addGroupStatusModal', '/settings-system/work-status/group-status-modal',['#status_tag']);
    })
});

function funcEditStatus(statusID) {
    showModalWithAjax('#editStatusModal', '/settings-system/work-status/show-edit-status/' + statusID, ['#edit_statusUse', '#edit_flagType', '#edit_statusOfStatus']);
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



