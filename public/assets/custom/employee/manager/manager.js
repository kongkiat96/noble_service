var setURLEmployee = '/employee'
var setURLBranch = setURLEmployee + '/manager'

$(document).ready(function () {
    $('#addManager').click(function () {
        showModalWithAjax('#addManagerModal', setURLBranch + '/add-manager-modal', ['#manager','#status_tag']);
    });
});