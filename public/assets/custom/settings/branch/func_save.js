var setURLSetting = '/settings-system'
var setURLBranch = setURLSetting + '/branch'

$(document).ready(function () {
    $("#saveBranch").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddBranch")[0];
        const fv = setupFormValidationBranch(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLBranch + "/save-branch", formData)
                    .done(onSaveBranchSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function onSaveBranchSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addBranchModal", "#formAddBranch");
}