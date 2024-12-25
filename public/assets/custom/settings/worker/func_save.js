var setURLSetting = '/settings-system'
var setURLWorker = setURLSetting + '/worker'


$(document).ready(function () {
    $('#saveWorker').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddWorker")[0];
        const fv = setupFormValidationWorker(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLWorker + "/save-worker", formData)
                    .done(onSaveWorkerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    $('#employee_id').on('change', function () {
        let employee_id = $(this).val();
        if (employee_id) {
            $.ajax({
                url: `/getMaster/get-about-employee/${employee_id}`,
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

function onSaveWorkerSuccess(response) {
    // console.log(response)
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addWorkerModal", "#formAddWorker");
}