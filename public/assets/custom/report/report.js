$(function () {
    var dt_SearchDataReport = $('.dt-search-datareport')
    dt_SearchDataReport.DataTable({
        processing: true,
        paging: true,
        pageLength: 200,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true,
        scrollX: true,
        fixedColumns: {
            leftColumns: 3
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        data: [], // เริ่มต้นด้วยข้อมูลว่าง
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            { data: "ticket", class: "text-nowrap" },
            {
                data: 'case_status',
                class: "text-center",
                render: badgeStatusTagWork
            },
            { data: "case_open", class: "text-nowrap" },
            { data: "sv_approve_date", class: "text-nowrap" },
            { data: "manager_department_approve_date", class: "text-nowrap" },
            { data: "case_open_branch", class: "text-nowrap" },
            { data: "category_main_name", class: "text-nowrap" },
            { data: "category_type_name", class: "text-nowrap" },
            { data: "category_detail_name", class: "text-nowrap" },
            { data: "category_item_name", class: "text-nowrap" },
            { data: "category_list_name", class: "text-nowrap" },
            { data: "sla", class: "text-nowrap" },
            { data: "cal_sla", class: "text-nowrap" },
            { data: "check_user_detail", class: "text-nowrap" },
            { data: "worker", class: "text-nowrap" },
            { data: "checker", class: "text-nowrap" },
            { data: "price", class: "text-nowrap" },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="bx bx-file me-2"></i>Export to Excel',
                className: 'btn btn-success', // ใช้ Bootstrap Class
                title: 'Data Report Case Service ', // ชื่อไฟล์ Excel
                autoFilter: true,
            }
        ]
    });

})

function reTable(){

}
$(document).ready(function () {
    $('#searchDataForReport').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var case_status = $('#case_status').val();
        var status_ticket = $('#status_ticket').val();
        var category_main_id = $('#category_main_id').val();
        var category_type_id = $('#category_type_id').val();
        var category_detail = $('#category_detail').val();
        var report_type = $('#reportType').val();
        // var category_type_id = $('#category_type_id').val();
        $.ajax({
            url: "/report/get-data-report/" + report_type,
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                start_date: start_date,
                end_date: end_date,
                case_status: case_status,
                status_ticket: status_ticket,
                category_main_id: category_main_id,
                category_type_id: category_type_id,
                category_detail: category_detail,
            },
            success: function (data) {
                // ล้างข้อมูลเก่าและอัปเดต DataTable
                const table = $('.dt-search-datareport').DataTable();
                table.clear(); // ล้างข้อมูลเดิม
                table.rows.add(data.data); // เพิ่มข้อมูลใหม่
                table.draw(); // วาดตารางใหม่
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    text: 'เกิดข้อผิดพลาดในการดึงข้อมูล',
                    showConfirmButton: false
                });
            }
        });
    });

    $('#resetSearchData').click(function () {
        window.location.reload();
    });
});