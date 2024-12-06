var setURLSetting = '/settings-system'
var setURLChecker = setURLSetting + '/checker'

$(document).ready(function () {
    $("#saveChecker").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddChecker")[0];
        const fv = setupFormValidationChecker(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLChecker + "/save-checker", formData)
                    .done(onSaveCheckerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
})

function onSaveCheckerSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCheckerModal", "#formAddChecker");
}