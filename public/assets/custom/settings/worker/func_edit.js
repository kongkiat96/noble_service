var setURLSetting = '/settings-system'
var setURLWorker = setURLSetting + '/worker'

$(document).ready(function () {
    $('#saveEditWorker').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditWorker")[0];
        const workerID = $('#workerID').val();
        const fv = setupFormValidationWorker(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLWorker + "/edit-worker/" + workerID, formData)
                    .done(onSaveEditWorkerSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })
});

function onSaveEditWorkerSuccess(response) {
    // console.log(response)
    handleAjaxEditResponse(response);
    closeAndResetModal("#editWorkerModal", "#formEditWorker");
}