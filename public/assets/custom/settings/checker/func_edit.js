var setURLSetting = '/settings-system'
var setURLChecker = setURLSetting + '/checker'

$(document).ready(function () {
    $("#editChecker").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditChecker")[0];
        const checkerID = $('#checkerID').val();
        const fv = setupFormValidationChecker(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLChecker + "/edit-checker/" + checkerID, formData)
                    .done(onSaveEditCheckerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
})

function onSaveEditCheckerSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCheckerModal", "#formEditChecker");
}