$(document).ready(function () {
    $('#saveCaseCCTV').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCaseCCTV")[0];
        const fv = setupFormValidationApprove(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCaseApprove + "/save-case-cctv", formData)
                    .done(onSaveCaseCCTVSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })    

    $('#saveCasePermission').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddCasePermission")[0];
        const fv = setupFormValidationApprove(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLCaseApprove + "/save-case-permission", formData)
                    .done(onSaveCasePermissionSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    }) 
});

function onSaveCaseCCTVSuccess(response) {
    // console.log(response)
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCaseCCTVModal", "#formAddCaseCCTV");
}

function onSaveCasePermissionSuccess(response) {
    // console.log(response)
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addCasePermissionModal", "#formAddCasePermission");
}