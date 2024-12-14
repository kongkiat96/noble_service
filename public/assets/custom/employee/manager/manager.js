var setURLEmployee = '/employee'
var setURLManager = setURLEmployee + '/manager'

$(function () {
    var dt_Manager = $('.dt-manager')
    dt_Manager.DataTable({
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
            url: setURLManager + "/get-data-manager",
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
                data: 'encrypt_id',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    const countTotal = (row.count_sub_manager);
                    return renderGroupSubManager(data, type, row, 'AddSubManager','info', countTotal);
                }
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
                    return renderGroupActionButtonsPermission(data, type, row, 'Manager', Permission);
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

$(document).ready(function () {
    $('#addManager').click(function () {
        showModalWithAjax('#addManagerModal', setURLManager + '/add-manager-modal', ['#manager_emp_id','#status_tag']);
    });
    
});

function reTable() {
    $('.dt-manager').DataTable().ajax.reload();
}

function setupFormValidationManager(formElement) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
    };

    const validationRules = {
        manager_emp_id: validators.notEmpty('เลือกข้อมูล พนักงาน'),
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

function renderGroupSubManager(data, type, row, useFunc,color,countTotal) {
    // console.log(row.SearchMonth)
    // alert(row.encrypt_id)
    const Function = `funcAction${useFunc}`;
    let returnButton = `
        <button type="button" class="btn btn-icon btn-label-${color} btn-${color}" onclick="${Function}('${row.encrypt_id}')">
            ${countTotal}
        </button>
    `;

    return returnButton;
}

function funcActionAddSubManager(encrypt_id) {
    // alert(encrypt_id);
    // console.log(encrypt_id,tag_search)
    location.href = setURLManager + '/add-sub-manager/' + encrypt_id;
}

function funcEditManager(managerID) {
    showModalWithAjax('#editManagerModal', setURLManager + '/show-edit-manager/' + managerID, ['#manager_emp_id','#status_tag']);
}

function funcDeleteManager(managerID) {
    handleAjaxDeleteResponse(managerID, setURLManager + "/delete-manager/" + managerID);
}