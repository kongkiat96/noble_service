$(document).ready(function () {
    $('#saveEditCaseCCTV').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditCaseApprove")[0];
        const caseApproveID = $('#caseApproveID').val();
        const fv = setupFormValidationApprove(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCaseApprove + "/edit-case-approve/" + caseApproveID, formData)
                    .done(onSaveEditCaseApproveSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })
});

function onSaveEditCaseApproveSuccess(response) {
    // console.log(response)
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCaseApproveModal", "#formEditCaseApprove");
}