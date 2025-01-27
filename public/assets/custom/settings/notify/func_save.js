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

        // ตรวจสอบว่ามีการเลือก alert_only หรือ alert_group หรือไม่
        const isAlertOnlyChecked = $('#alert_only').is(':checked'); // ตรวจสอบ alert_only
        const isAlertGroupChecked = $('#alert_group').is(':checked'); // ตรวจสอบ alert_group

        // ถ้าไม่มีการเลือกตัวใดตัวหนึ่ง
        if (!isAlertOnlyChecked && !isAlertGroupChecked) {
            // alert('กรุณาเลือก Alert Only หรือ Alert Group ก่อนดำเนินการ');
            Swal.fire({
                icon: 'warning',
                text: 'กรุณาเลือกประเภทการแจ้งเตือน ก่อนดำเนินการ',
                confirmButtonText: "ตกลง",
            });
            return;
        }
        // ดำเนินการต่อถ้ามีการเลือกแล้ว
        $("#saveNotiTelegram").attr("disabled", true);
        // $('#alert_only').attr('disabled', true);
        // $('#alert_group').attr('disabled', true);

        const form = $("#formAddTokenTelegram")[0];
        const formData = new FormData(form);

        postFormData("/settings-system/setnotify-telegram/search-chat-id/" + token, formData)
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

        // เปิดปุ่ม Save
        $("#saveNotiTelegram").attr("disabled", false);

        // ปิดการแก้ไข token และ searchChatID
        $("#searchChatID").attr("disabled", true);
        $("#token").attr("readonly", true);

        // ตรวจสอบว่าผู้ใช้เลือกอะไร
        if ($('#alert_only').is(':checked')) {
            // ถ้าเลือก alert_only ให้ disable alert_group
            $('#alert_group').attr('disabled', true);
            $('#alert_only').attr('disabled', false);
        } else if ($('#alert_group').is(':checked')) {
            // ถ้าเลือก alert_group ให้ disable alert_only
            $('#alert_only').attr('disabled', true);
            $('#alert_group').attr('disabled', false);
        }
    } else {
        // กรณีไม่มี chat_id ให้เปิดทุกตัวเลือก
        $("#saveNotiTelegram").attr("disabled", false);
        $('#alert_only').attr('disabled', false);
        $('#alert_group').attr('disabled', false);

        // แจ้งเตือนผู้ใช้
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