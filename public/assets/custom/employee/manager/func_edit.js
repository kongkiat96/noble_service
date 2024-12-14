var setURLEmployee = '/employee'
var setURLManager = setURLEmployee + '/manager'
var setURLSubManager = setURLManager + '/sub-manager'

$(document).ready(function () {
    $("#saveEditManager").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditManager")[0];
        const managerID = $('#managerID').val();
        const fv = setupFormValidationManager(form,'manager_emp_id');
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLManager + "/edit-manager/" + managerID, formData)
                    .done(onSaveEditManagerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveEditSubManager").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditSubManager")[0];
        const subManagerID = $('#subManagerID').val();
        const fv = setupFormValidationManager(form, 'sub_emp_id');
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLSubManager + "/edit-sub-manager/" + subManagerID, formData)
                    .done(onSaveEditSubManagerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $('#manager_emp_id,#sub_emp_id').on('change', function () {
        let managerId = $(this).val();
        // alert(managerId);
        // return
        if (managerId) {
            $.ajax({
                url: `/getMaster/get-about-employee/${managerId}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#company_name_th').val(data.company_name_th);
                    $('#class_name').val(data.class_name);
                    $('#position_name').val(data.position_name);
                    $('#department_name').val(data.department_name);
                    $('#group_name').val(data.group_name);
                    $('#branch_name').val(data.branch_name);
                    $('#branch_code').val(data.branch_code);
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        text: 'เกิดข้อผิดพลาดในการดึงข้อมูล',
                        showConfirmButton: false
                    });
                }
            });
        } else {
            $('#company_name_th').val('');
            $('#class_name').val('');
            $('#position_name').val('');
            $('#department_name').val('');
            $('#group_name').val('');
            $('#branch_name').val('');
            $('#branch_code').val('');
        }
    });
});


function onSaveEditManagerSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editManagerModal", "#formEditManager");
}   

function onSaveEditSubManagerSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editSubManagerModal", "#formEditSubManager");
} 