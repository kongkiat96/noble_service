var setURLSetting = '/settings-system'
var setURLCategoryIT = setURLSetting + '/set-type-category-it'
var setURLCategoryMT = setURLSetting + '/set-type-category-mt'
var setURLCategoryTools = setURLSetting + '/set-type-category-tools'

$(document).ready(function () {
    $("#saveEditCategoryMain").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditCategoryMain")[0];
        const categoryMainID = $('#categoryMainID').val();
        const fv = setupFormValidationCategoryMain(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/edit-category-main/" + categoryMainID, formData)
                    .done(onSaveEditCategoryMainSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function onSaveEditCategoryMainSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCategoryMainModal", "#formEditCategoryMain");
}