var setURLCaseService = '/case-service'
var setURLService = '/service'
var setURLCase = setURLService + '/case'
$(function () {
    var dt_WaitApprove = $('.dt-case-wait-approve')
    dt_WaitApprove.DataTable({
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
            url: setURLCaseService + "/get-data-case-wait-approve-it",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "IT",
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
                data: 'updated_user',
                class: "text-center",
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_OpenCase = $('.dt-case-openCase')
    dt_OpenCase.DataTable({
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
            url: setURLCaseService + "/get-data-case-open-it",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "IT",
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
                data: 'updated_user',
                class: "text-center",
            },
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_CaseWorking = $('.dt-case-working')
    dt_CaseWorking.DataTable({
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
            url: setURLCaseService + "/get-data-case-doing-it",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "IT",
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
                data: 'case_status',
                class: "text-center",
                render: function (data, type, row) {
                    return badgeStatusTagWork(data);
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
                data: 'updated_user',
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


    var dt_CaseSuccess = $('.dt-case-success')
    dt_CaseSuccess.DataTable({
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
            url: setURLCaseService + "/get-data-case-success-it",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": "IT",
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
                data: 'case_status',
                class: "text-center",
                render: function (data, type, row) {
                    return badgeStatusTagWork(data);
                }
            },
            {
                data: 'check_price',
                class: "text-center",
                render: function (data, type, row) {
                    if (data == 0.00) {
                        return `
                        <span class="badge bg-label-danger">รอบันทึกค่าใช้จ่าย</span>
                    `;
                    } else {
                        return `
                        <span class="badge bg-label-success">บันทึกค่าใช้จ่ายแล้ว</span>
                    `;
                    }
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
                data: 'updated_user',
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
    $('.dt-case-wait-approve').DataTable().ajax.reload(null, false);
    $('.dt-case-openCase').DataTable().ajax.reload(null, false);
    $('.dt-case-working').DataTable().ajax.reload(null, false);
    $('.dt-case-success').DataTable().ajax.reload(null, false);
}
$(document).ready(function () {
    scheduleFetch("/case-service/realtime-case-new-count/wait-approve-it", "caseCountWaitApproveIT", 90000);
    scheduleFetch("/case-service/realtime-case-new-count/it", "caseNewCountIT", 90000); // สำหรับ MT
    scheduleFetch("/case-service/realtime-case-doing-count/it", "caseDoingCountIT", 90000);
    scheduleFetch("/case-service/realtime-case-success-count/it", "caseSuccessCountIT", 90000);
    setInterval(reTable, 90000);
});

function getDetailCase(ticket) {
    // $('.dt-approve-history').DataTable().ajax.reload();
    setTimeout(() => {
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    }, 100);  // เพิ่มดีเลย์เล็กน้อย
    $.ajax({
        type: 'GET',
        url: setURLCaseService + "/case-action/" + ticket,
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
                    // render: badgeStatusTagWork
                    render: function (data, type, row) {
                        return badgeStatusTagWork(data);
                    }
                },
                {
                    data: 'CaseDetail',
                    // class: "text-wrap",
                },
                {
                    data: 'CasePrice',
                    class: "text-center",
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
