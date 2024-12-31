var setURLEmployee = '/employee'
var setURLManager = setURLEmployee + '/manager'
var setURLSubManager = setURLManager + '/sub-manager'
var managerID = $('#managerID').val();
$(function () {
    var dt_Manager = $('.dt-manager')
    var dt_SubManager = $('.dt-sub-manager')
    var dt_SearchManager = $('.dt-search-manager')
    dt_Manager.DataTable({
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
                    return renderGroupSubManager(data, type, row, 'AddSubManager', 'info', countTotal);
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

    dt_SubManager.DataTable({
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
            url: setURLSubManager + "/get-data-sub-manager",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "managerID": managerID
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
                    return renderGroupActionButtonsPermission(data, type, row, 'SubManager', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    dt_SearchManager.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true,
        scrollX: true,
        fixedColumns: {
            leftColumns: 3
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        data: [], // เริ่มต้นด้วยข้อมูลว่าง
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'full_name_manager',
                class: "text-center",
            },
            {
                data: 'full_name_sub_manager',
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
            { data: 'created_at', class: "text-center" },
            { data: 'created_user', class: "text-center" },
            { data: 'updated_at', class: "text-center" },
            { data: 'updated_user', class: "text-center" },
            // {
            //     data: 'ID',
            //     orderable: false,
            //     searchable: false,
            //     class: "text-center",
            //     render: function (data, type, row) {
            //         const Permission = (row.Permission);
            //         return renderGroupActionButtonsPermission(data, type, row, 'SubManager', Permission);
            //     }
            // }
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
        showModalWithAjax('#addManagerModal', setURLManager + '/add-manager-modal', ['#manager_emp_id', '#status_tag']);
    });

    $('#addSubManager').click(function () {
        showModalWithAjax('#addSubManagerModal', setURLSubManager + '/add-sub-manager-modal/' + managerID, ['#sub_emp_id', '#status_tag']);
    });

    $('#searchDataManager').click(function (e) {
        e.preventDefault();
        // ดึงค่าจากฟอร์มที่กรอกข้อมูลไว้
        var manager_id = $('#manager_id').val();
        var sub_emp_id = $('#sub_emp_id').val();

        if (manager_id !== '' && sub_emp_id !== '' || (manager_id === '' && sub_emp_id === '')) {
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกเพียงหนึ่งข้อมูลในการค้นหา',
                showConfirmButton: false
            });

            return true;
        }
        $.ajax({
            url: setURLManager + "/get-data-search-manager",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                "manager_id": manager_id,
                "sub_emp_id": sub_emp_id
            },
            // dataType: 'json',
            success: function (data) {
                // ล้างข้อมูลเก่าและอัปเดต DataTable
                const table = $('.dt-search-manager').DataTable();
                table.clear(); // ล้างข้อมูลเดิม
                table.rows.add(data.data); // เพิ่มข้อมูลใหม่
                table.draw(); // วาดตารางใหม่
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    text: 'เกิดข้อผิดพลาดในการดึงข้อมูล',
                    showConfirmButton: false
                });
            }
        });
    })

    $('#resetSearchManager').click(function (e) {
        // alert("sss")
        e.preventDefault();
        $('#manager_id').val('').trigger('change');
        $('#sub_emp_id').val('').trigger('change');
        $('.dt-search-manager').DataTable().clear().draw();
    })

});

function reTable() {
    $('.dt-manager').DataTable().ajax.reload();
    $('.dt-sub-manager').DataTable().ajax.reload();
}

function setupFormValidationManager(formElement, setSelect) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
    };
    const validationRules = {
        [setSelect]: validators.notEmpty('เลือกข้อมูล พนักงาน'),
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

function renderGroupSubManager(data, type, row, useFunc, color, countTotal) {
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
    location.href = setURLManager + '/sub-manager/' + encrypt_id;
}

function funcEditManager(managerID) {
    showModalWithAjax('#editManagerModal', setURLManager + '/show-edit-manager/' + managerID, ['#manager_emp_id', '#status_tag']);
}

function funcEditSubManager(subManagerID) {
    showModalWithAjax('#editSubManagerModal', setURLSubManager + '/show-edit-sub-manager/' + subManagerID, ['#sub_emp_id', '#status_tag']);
}
function funcDeleteManager(managerID) {
    handleAjaxDeleteResponse(managerID, setURLManager + "/delete-manager/" + managerID);
}

function funcDeleteSubManager(subManagerID) {
    handleAjaxDeleteResponse(subManagerID, setURLSubManager + "/delete-sub-manager/" + subManagerID);
}