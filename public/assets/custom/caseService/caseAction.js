$(document).ready(function () {
    $('#saveCaseAction').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formDoingCaseAction")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationDoingCaseAction(form);
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
                postFormData("/case-service/case-doing-action/" + caseID, formData)
                    .done(onSaveCaseActionSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $('#saveCaseAddprice').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formCaseAddPrice")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationCaseAddPrice(form);
        const formData = new FormData(form);
        console.log(formData)
        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/service/approve-case/case-check-work/" + caseID, formData)
                    .done(onSaveCaseActionSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

})

function setupFormValidationDoingCaseAction(formElement, setSelect) {
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
        case_item: validators.notEmpty('เลือกข้อมูล รายการที่เสีย'),
        case_list: validators.notEmpty('เลือกข้อมูล รายการที่แก้ไขปัญหา'),
        case_status: validators.notEmpty('เลือกข้อมูล สถานะการทำงาน'),
        case_doing_detail: validators.notEmptyAndRegexp('ระบุ รายละเอียด', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-12, .col-md-6'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function setupFormValidationCaseAddPrice(formElement, setSelect) {
    const validators = {
        notEmptyAndRegexp: (message, regexp) => ({
            validators: {
                notEmpty: { message },
                regexp: { regexp, message: 'ข้อมูลไม่ถูกต้อง' }
            }
        }),
    };
    const validationRules = {
        case_price: validators.notEmptyAndRegexp(
            'ระบุ ค่าใช้จ่าย', 
            /^[0-9]{1,3}(?:,[0-9]{3})*(?:\.[0-9]{1,2})?$/
        ),
    };
    

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-9'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function formatAmount(input) {
    $('input.numeral-mask').on('blur', function () {
        const value = this.value.replace(/,/g, '');
        this.value = parseFloat(value).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        });
    });
}

function onSaveCaseActionSuccess(response) {

    if (response.status === 200) {
        Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลสำเร็จ',
            confirmButtonText: 'ตกลง'
        }).then((result) => {
            window.location.reload();
        });
    } else {
        Swal.fire({
            icon: 'error',
            text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        })
    }
}