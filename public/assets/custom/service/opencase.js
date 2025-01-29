$(document).ready(function () {
    $('#openCaseService').click(function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formOpenCaseService")[0];
        const fv = setupFormValidationOpenCaseService(form);
        const formData = new FormData(form);
        const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

        // Include files from Dropzone in formData
        const myDropzone = Dropzone.forElement("#pic-case");
        if (myDropzone.files.length > 0) {
            for (let file of myDropzone.files) {
                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        text: `ไฟล์ "${file.name}" มีขนาดใหญ่เกิน ${maxFileSize / (1024 * 1024)}MB. กรุณาเลือกไฟล์ขนาดเล็กกว่า.`,
                        showConfirmButton: false,
                        timer: 5500
                    });
                    return; // Stop form submission if any file exceeds the limit
                }
                formData.append("file[]", file); // Use file[] if you want to send multiple files
            }
        }


        fv.validate().then(function (status) {
            if (status === 'Valid') {
                $('#openCaseService').attr("disabled", true);
                postFormData("/service/case/open-case-service", formData)
                    .done(onSaveOpenCaseServiceSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    $('#resetFormOpenCaseService').click(function (e) {
        $('#formOpenCaseService')[0].reset();
        $('.select2').val(null).trigger('change');
        resetDropzone();
    })

    $('#employee_other_case').on('change', function () {
        let emp_id = $(this).val();
        if (emp_id) {
            $.ajax({
                url: `/getMaster/get-data-manager/${emp_id}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#manager_name').val(data.full_name_manager);
                    $('#manager_emp_id').val(data.manager_emp_id);
                    $('#sub_emp_id').val(data.sub_emp_id);

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
            var empID = $('#empID').data('empid');

            $.ajax({
                url: `/getMaster/get-data-manager/${empID}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#manager_name').val(data.full_name_manager);
                    $('#manager_emp_id').val(data.manager_emp_id);
                    $('#sub_emp_id').val(data.sub_emp_id);

                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        text: 'เกิดข้อผิดพลาดในการดึงข้อมูล',
                        showConfirmButton: false
                    });
                }
            });
        }
    });
});

function setupFormValidationOpenCaseService(formElement, setSelect) {
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
        use_tag: validators.notEmpty('เลือกข้อมูล ฝ่ายที่ต้องการแจ้งปัญหา'),
        category_main: validators.notEmpty('เลือกข้อมูล รายการกลุ่มอุปกรณ์'),
        category_type: validators.notEmpty('เลือกข้อมูล รายการประเภทหมวดหมู่'),
        category_detail: validators.notEmpty('เลือกข้อมูล อาการที่ต้องการแจ้งปัญหา'),
        case_detail: validators.notEmptyAndRegexp('ระบุ รายละเอียด', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-6,.col-md-12'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function onSaveOpenCaseServiceSuccess(response) {

    if (response.status === 200) {
        Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลสำเร็จ',
            confirmButtonText: 'ตกลง'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formOpenCaseService')[0].reset();
                $('.select2').val(null).trigger('change');
                resetDropzone();
                $("#openCaseService").attr("disabled", false);

            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        })
        $("#openCaseService").attr("disabled", false);
    }
}
