$(function () {
    var dt_SearchDataReport = $('.dt-search-datareport')
    dt_SearchDataReport.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
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
            { data: "employee_code", class: "text-nowrap" },
            // { data: "email", class: "text-nowrap" },
            // { data: "full_name", class: "text-nowrap" },
            // { data: "class_name", class: "text-nowrap" },
            // { data: "position_name", class: "text-nowrap" },
            // { data: "company_name_th", class: "text-nowrap" },
            // { data: "department_name", class: "text-nowrap" },
            // { data: "group_name", class: "text-nowrap" },
            // { data: "branch_name", class: "text-nowrap" },
            // { data: "user_class", class: "text-nowrap", render: renderUserClassBadge },
            // {
            //     data: "status_login",
            //     orderable: false,
            //     searchable: false,
            //     class: "text-center",
            //     render: renderStatusBadge
            // },
            // {
            //     data: 'ID',
            //     orderable: false,
            //     searchable: false,
            //     class: "text-center",
            //     render: (data, type, row) => renderGroupActionButtonsForSearchEmployee(data, type, row, 'EmployeeCurrent')
            // }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

})


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