$(document).ready(function () {
    $('#saveCaseAction').on('click', function (e) {
        alert("sd")
        return
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCaseAction")[0];
        const fv = setupFormValidationCaseAction(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/case-service/mt/save-case-action", formData)
                    .done(onSaveCaseActionSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
})