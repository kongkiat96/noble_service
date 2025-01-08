$(document).ready(function () {
    $("#saveEditStatus").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditStatus")[0];
        const statusID = $('#statusID').val();
        const fv = setupFormValidationStatus(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/settings-system/work-status/edit-status/" + statusID, formData)
                    .done(onSaveEditStatusSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveEditGroupStatus").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditGroupStatus")[0];
        const groupStatusID = $('#groupStatusID').val();
        const fv = setupFormValidationGroupStatus(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/settings-system/work-status/edit-group-status/" + groupStatusID, formData)
                    .done(onSaveEditGroupStatusSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function setupFormValidationEditStatus(formElement) {
    return FormValidation.formValidation(formElement, {
        fields: {
            edit_statusName: {
                validators: {
                    notEmpty: {
                        message: 'ระบุชื่อสถานะ'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9ก-๏\s./]+$/u,
                        message: 'ข้อมูลไม่ถูกต้อง'
                    }
                }
            },
            edit_statusUse: {
                validators: {
                    notEmpty: {
                        message: 'เลือกข้อมูล รูปแบบการใช้งาน'
                    }
                }
            },
            edit_flagType: {
                validators: {
                    notEmpty: {
                        message: 'เลือกข้อมูล สถานะการทำงาน'
                    }
                }
            },
            edit_statusOfStatus: {
                validators: {
                    notEmpty: {
                        message: 'เลือกข้อมูล สถานะ'
                    }
                }
            }
        },
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

function onSaveEditStatusSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editStatusModal", "#formEditStatus");
}

function onSaveEditGroupStatusSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editGroupStatusModal", "#formEditGroupStatus");
}

$(document).ready(function () {
    $("#saveEditFlagType").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditFlagType")[0];
        const flagTypeID = $('#flagTypeID').val();
        const fv = setupFormValidationEditFlagType(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/settings-system/work-status/edit-flag-type/" + flagTypeID, formData)
                    .done(onSaveEditFlagTypeSuccess)
                    .fail(handleAjaxSaveError);
            }
        })
    })
})

function setupFormValidationEditFlagType(formElement) {
    return FormValidation.formValidation(formElement, {
        fields: {
            edit_flagName: {
                validators: {
                    notEmpty: {
                        message: 'ระบุ ชื่อรายการรูปแบบสถานะงาน'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9ก-๏\s./]+$/u,
                        message: 'ข้อมูลไม่ถูกต้อง'
                    }
                }
            },
            edit_typeWork: {
                validators: {
                    notEmpty: {
                        message: 'เลือกข้อมูล รูปแบบของสถานะ'
                    }
                }
            }
        },
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

function onSaveEditFlagTypeSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editFlagTypeModal", "#formEditFlagType");
}
