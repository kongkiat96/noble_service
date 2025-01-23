$(document).ready(function () {
    $("#saveNotiTelegram").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddTokenTelegram")[0];
        const fv = setupFormValidationSetTelegram(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/settings-system/setnotify-telegram/save-notify-telegram", formData)
                    .done(onSaveNotifySuccess)
                    .fail(handleAjaxSaveError);
            }
        })
    });

    $('#searchChatID').click(function () {
        const token = $('#token').val();
        // alert(token);
        $("#saveNotiTelegram").attr("disabled", true);
        postFormData("/settings-system/setnotify-telegram/search-chat-id/" + token)
            .done(onCheckChatIDSuccess)
            .fail(handleAjaxSaveError);
    });
});

function onCheckChatIDSuccess(data) {
    console.log(data);
    // ตรวจสอบว่ามี chat_id หรือไม่
    if (data && data.chat_id) {
        // นำ chat_id มาใส่ใน input
        document.getElementById('chat_id').value = data.chat_id;
        $("#saveNotiTelegram").attr("disabled", false);
        $("#searchChatID").attr("disabled", true);
        $("#token").attr("readonly", true);

    } else {
        $("#saveNotiTelegram").attr("disabled", false);
        // กรณีไม่มี chat_id ให้แจ้งเตือนผู้ใช้
        Swal.fire({
            icon: 'warning',
            text: 'ไม่พบข้อมูล Chat ID',
            confirmButtonText: "ตกลง",
        });

    }
}

function onSaveNotifySuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addTokenModal", "#formAddTokenTelegram");
}