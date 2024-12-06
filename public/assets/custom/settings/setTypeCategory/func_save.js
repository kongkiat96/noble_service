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
                postFormData(setURLCategoryTools + "/save-category-main", formData)
                    .done(onSaveCategoryMainSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveCategoryType").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCategoryType")[0];
        const fv = setupFormValidationCategoryType(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/save-category-type", formData)
                    .done(onSaveCategoryTypeSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveCategoryDetail").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCategoryDetail")[0];
        const fv = setupFormValidationCategoryDetail(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/save-category-detail", formData)
                    .done(onSaveCategoryDetailSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveCategoryItem").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCategoryItem")[0];
        const fv = setupFormValidationCategoryItem(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCategoryTools + "/save-category-item", formData)
                    .done(onSaveCategoryItemSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })
});

function onSaveCategoryMainSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCategoryMainModal", "#formAddCategoryMain");
}

function onSaveCategoryTypeSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCategoryTypeModal", "#formAddCategoryType");
}

function onSaveCategoryDetailSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCategoryDetailModal", "#formAddCategoryDetail");
}

function onSaveCategoryItemSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCategoryItemModal", "#formAddCategoryItem");
}