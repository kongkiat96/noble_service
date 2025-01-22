$(document).ready(function () {
    $('#editNotiTelegram').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formEditTokenTelegram")[0];
        const telegramID = $('#telegramID').val();
        const fv = setupFormValidationSetTelegram(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData("/settings-system/setnotify-telegram/edit-notify-telegram/" + telegramID, formData)
                    .done(onSaveEditTokenSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    $('#searchChatID').click(function () {
        const token = $('#token').val();
        // alert(token);
        $("#editNotiTelegram").attr("disabled", true);
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
        $("#editNotiTelegram").attr("disabled", false);
        $("#searchChatID").attr("disabled", true);
        $("#token").attr("readonly", true);

    } else {
        $("#editNotiTelegram").attr("disabled", false);
        document.getElementById('chat_id').value = "";
        // กรณีไม่มี chat_id ให้แจ้งเตือนผู้ใช้
        Swal.fire({
            icon: 'warning',
            text: 'ไม่พบข้อมูล Chat ID',
            confirmButtonText: "ตกลง",
        });

    }
}

function onSaveEditTokenSuccess(response) {
    // console.log(response)
    handleAjaxEditResponse(response);
    closeAndResetModal("#editTokenModal", "#formEditTokenTelegram");
}