var setURLService = '/service'
var setURLCase = setURLService + '/case'
var setURLApprove = setURLService + '/approve-case'
$(function () {
    var dt_ApproveMT = $('.dt-approve-mt')
    dt_ApproveMT.DataTable({
        processing: false,
        paging: true,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true, // เปลี่ยนเป็น true
        scrollX: true,
        fixedColumns: {
            leftColumns: 2
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        ajax: {
            url: setURLApprove + "/get-data-approve-mt",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "MT",
                });
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'ticket',
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return `
                        <button type="button" class="btn btn-label-info btn-info btn-sm" onclick="getDetailCase('` + row.ticket + `')">
                            ` + row.ticket + `
                        </button>
                    `;
                }
            },
            {
                data: 'employee_other_case',
                class: "text-center",
            },
            {
                data: 'created_at',
                class: "text-center",
            },

            {
                data: 'category_main_name',
                class: "text-center",
            },
            {
                data: 'category_type_name',
                class: "text-center",
            },
            {
                data: 'category_detail_name',
                class: "text-center",
            },
            {
                data: 'created_user',
                class: "text-center",
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_ApproveFU = $('.dt-approve-fu')
    dt_ApproveFU.DataTable({
        processing: false,
        paging: true,
        pageLength: 50,
        deferRender: true,
        ordering: true,
        lengthChange: true,
        bDestroy: true, // เปลี่ยนเป็น true
        scrollX: true,
        fixedColumns: {
            leftColumns: 2
        },
        language: {
            processing:
                '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
        },
        ajax: {
            url: setURLApprove + "/get-data-approve-fu",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "MT",
                });
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                data: 'ticket',
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return `
                        <button type="button" class="btn btn-label-info btn-info btn-sm" onclick="getDetailCase('` + row.ticket + `')">
                            ` + row.ticket + `
                        </button>
                    `;
                }
            },
            {
                data: 'employee_other_case',
                class: "text-center",
            },
            {
                data: 'created_at',
                class: "text-center",
            },

            {
                data: 'category_main_name',
                class: "text-center",
            },
            {
                data: 'category_type_name',
                class: "text-center",
            },
            {
                data: 'category_detail_name',
                class: "text-center",
            },
            {
                data: 'created_user',
                class: "text-center",
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    
})

function reTable() {
    // $('.dt-approve-case-it').DataTable().ajax.reload();
    $('.dt-approve-mt').DataTable().ajax.reload(null, false);
    $('.dt-approve-fu').DataTable().ajax.reload(null, false);
}
$(document).ready(function () {
    // ฟังก์ชันทั่วไปสำหรับดึงข้อมูลจำนวนอนุมัติ
    function fetchCountApprove(url, badgeId) {
        $.ajax({
            url: url, // URL ที่ใช้เรียกข้อมูล
            type: "GET",
            success: function (response) {
                // อัปเดตจำนวนใน badge ที่ระบุ
                $(`#${badgeId}`).text(response.count);
            },
            error: function (xhr, status, error) {
                console.error(`Error fetching count from ${url}:`, error);
            }
        });
    }

    // เรียกข้อมูลสำหรับ MT
    function fetchCountMT() {
        fetchCountApprove("/service/approve-case/realtime-case-approve-count-mt", "caseApproveCountMT");
    }

    // เรียกข้อมูลสำหรับ FU
    function fetchCountFU() {
        fetchCountApprove("/service/approve-case/realtime-case-approve-count-fu", "caseApproveCountFU");
    }

    // เรียกฟังก์ชันทันทีที่หน้าโหลด
    fetchCountMT();
    fetchCountFU();

    // ตั้งเวลาเรียกฟังก์ชันทุก 1 นาที (60000 มิลลิวินาที)
    setInterval(fetchCountMT, 60000);
    setInterval(fetchCountFU, 60000);

    // setInterval(reTable, 60000);
});

function getDetailCase(ticket) {
        $('.dt-approve-history').DataTable().ajax.reload();

    $.ajax({
        type: 'GET',
        url: setURLCase + "/get-detail-case-approve/" + ticket,
    }).done(function (data) {
        $('#ticket-detail').html(data);
        $('.select2').select2({
            placeholder: "เลือกข้อมูล"
        });
        const textarea = document.querySelectorAll('textarea')
        if (textarea) {
            autosize(textarea);
        }


        var dt_History = $('.dt-approve-history')
        dt_History.DataTable({
            processing: true,
            searching: false,
            paging: false,
            pageLength: 50,
            deferRender: true,
            ordering: true,
            lengthChange: false,
            bDestroy: true, // เปลี่ยนเป็น true
            scrollX: false,
            
            language: {
                processing:
                    '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>',
            },
            ajax: {
                url: setURLCase + "/get-detail-case-history",
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: function (d) {
                    return $.extend({}, d, {
                        "caseID": $("#caseID").val(),
                    });
                }
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                },
                {
                    data: 'CaseStatus',
                    class: "text-center",
                    render: badgeStatusTagWork
                },
                {
                    data: 'CaseDetail',
                    class: "text-wrap",
                },
                {
                    data: 'CreatedAt',
                    class: "text-center",
                },
                {
                    data: 'CreatedUserName',
                    class: "text-center",
                },
            ],
            columnDefs: [
                {
                    targets: 0,
                },
            ],
        });

    }).fail(function (data) {
        console.log(data)
        Swal.fire({
            icon: 'error',
            text: 'เกิดข้อผิดพลาดในการแสดงข้อมูล',
            showConfirmButton: true,
        });
    });
}
