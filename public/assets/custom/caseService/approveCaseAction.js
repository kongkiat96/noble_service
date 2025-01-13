var setURLService = '/service'
var setURLCase = setURLService + '/case'
var setURLApprove = setURLService + '/approve-case'
$(document).ready(function () {
    $('#approveCaseToPadding').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formApproveToPadding")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationApproveCase(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLApprove + "/approve-case-padding/" + caseID, formData)
                    .done(onSaveApproveCaseSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    $('#saveManagerCaseCheckWork').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formManagerCaseCheckWork")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationApproveCase(form);
        const formData = new FormData(form);
        console.log(formData)
        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLApprove + "/case-check-work/" + caseID, formData)
                    .done(onSaveApproveCaseSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })


});


function setupFormValidationApproveCase(formElement, setSelect) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
        // notEmptyAndRegexp: (message, regexp) => ({
        //     validators: {
        //         notEmpty: { message },
        //         regexp: { regexp, message: 'ข้อมูลไม่ถูกต้อง' }
        //     }
        // }),
    };
    const validationRules = {
        case_status: validators.notEmpty('เลือกข้อมูล สถานะการอนุมัติ'),
        // case_detail: validators.notEmptyAndRegexp('ระบุ รายละเอียด', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-12'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function onSaveApproveCaseSuccess(response) {

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