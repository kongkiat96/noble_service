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

    $("#saveEditCategoryType").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditCategoryType")[0];
        const categoryTypeID = $('#categoryTypeID').val();
        const fv = setupFormValidationCategoryType(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/edit-category-type/" + categoryTypeID, formData)
                    .done(onSaveEditCategoryTypeSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveEditCategoryDetail").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditCategoryDetail")[0];
        const categoryDetailID = $('#categoryDetailID').val();
        const fv = setupFormValidationCategoryDetail(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/edit-category-detail/" + categoryDetailID, formData)
                    .done(onSaveEditCategoryDetailSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function onSaveEditCategoryMainSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCategoryMainModal", "#formEditCategoryMain");
}

function onSaveEditCategoryTypeSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCategoryTypeModal", "#formEditCategoryType");
}

function onSaveEditCategoryDetailSuccess(response) {
    handleAjaxEditResponse(response);
    closeAndResetModal("#editCategoryDetailModal", "#formEditCategoryDetail");
}