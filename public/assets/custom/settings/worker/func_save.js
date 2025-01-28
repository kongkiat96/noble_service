var setURLSetting = '/settings-system'
var setURLWorker = setURLSetting + '/worker'


$(document).ready(function () {
    $('#saveWorker').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddWorker")[0];
        const fv = setupFormValidationWorker(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLWorker + "/save-worker", formData)
                    .done(onSaveWorkerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })    
});

function onSaveWorkerSuccess(response) {
    // console.log(response)
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addWorkerModal", "#formAddWorker");
}