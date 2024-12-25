var setURLSetting = '/settings-system'
var setURLWorker = setURLSetting + '/worker'
$(function () {
    var dt_Worker = $('.dt-worker')
    dt_Worker.DataTable({
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
    $('.dt-worker').DataTable().ajax.reload();
}
$(document).ready(function () {
    $('#addWorker').click(function () {
        showModalWithAjax('#addWorkerModal', setURLWorker + '/add-worker-modal', ['#employee_id', '#use_tag', '#status_tag']);
    });
});

function funcEditWorker(workerID) {
    // alert(workerID);
    showModalWithAjax('#editWorkerModal', setURLWorker + '/show-edit-worker/' + workerID, ['#employee_id', '#use_tag', '#status_tag']);
}

function setupFormValidationWorker(formElement) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
    };
    const validationRules = {
        employee_id: validators.notEmpty('เลือกข้อมูล พนักงาน'),
        use_tag: validators.notEmpty('เลือกข้อมูล ฝ่ายที่ปฏิบัติงาน'),
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
