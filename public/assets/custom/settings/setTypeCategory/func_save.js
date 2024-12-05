var setURLSetting = '/settings-system'
var setURLCategoryIT = setURLSetting + '/set-type-category-it'
var setURLCategoryMT = setURLSetting + '/set-type-category-mt'
var setURLCategoryTools = setURLSetting + '/set-type-category-tools'

$(document).ready(function () {
    $("#saveCategoryMain").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCategoryMain")[0];
        const fv = setupFormValidationCategoryMain(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/save-category", formData)
                    .done(onSaveCategoryMainSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function onSaveCategoryMainSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCategoryMainModal", "#formAddCategoryMain");
}