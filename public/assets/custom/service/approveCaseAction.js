var setURLService = '/service'
var setURLCase = setURLService + '/case'
var setURLApprove = setURLService + '/approve-case'

$(function () {
    var dt_History = $('.dt-approve-history')
    dt_History.DataTable({
        processing: true,
        searching: false,
        paging: false,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: false,
        bDestroy: true, // เปลี่ยนเป็น true
        scrollX: false,

        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        ajax: {
            url: setURLCase + "/get-detail-case-history",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "caseID": $("#caseID").val(),

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
                data: 'CaseStatus',
                class: "text-center",
                render: badgeStatusTagWork
            },
            {
                data: 'CaseDetail',
                // class: "text-wrap",
            },
            {
                data: 'CasePrice',
                class: "text-center",
            },
            {
                data: 'CreatedAt',
                class: "text-center",
            },
            {
                data: 'CreatedUserName',
                class: "text-center",
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });
})
$(document).ready(function () {
    $('#approveCaseManager').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formApproveManager")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationApproveCase(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLApprove + "/approve-case-manager/" + caseID, formData)
                    .done(onSaveApproveCaseSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    $('#saveCaseCheckWork').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formCaseCheckWork")[0];
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



function setupFormValidationApproveCase(formElement) {
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
        case_status: validators.notEmpty('เลือกข้อมูล สถานะ'),
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