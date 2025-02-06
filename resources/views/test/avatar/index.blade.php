<button onclick="showNotification()">ทดสอบแจ้งเตือน</button>
    <script>
        function showNotification() {
            if (Notification.permission === "granted") {
                new Notification("📩 Gmail Notification", {
                    body: "Somebody requested a new password for your Facebook account",
                    icon: "https://cdn-icons-png.flaticon.com/512/281/281769.png"
                });
            } else {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        showNotification();
                    }
                });
            }
        }

        // setInterval(() => {
        //     showNotification()
        // }, 10000);

        // ตรวจสอบสิทธิ์แจ้งเตือนเมื่อโหลดหน้าเว็บ
        document.addEventListener("DOMContentLoaded", function () {
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            }
        });
    </script>