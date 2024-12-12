var setURLSetting = '/settings-system'
var setURLBranch = setURLSetting + '/branch'

$(document).ready(function () {
    $("#saveEditBranch").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditBranch")[0];
        const branchID = $('#branchID').val();
        const fv = setupFormValidationBranch(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLBranch + "/edit-branch/" + branchID, formData)
                    .done(onSaveEditBranchSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function onSaveEditBranchSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editBranchModal", "#formEditBranch");
}   