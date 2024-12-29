var setURLCaseService = '/case-service'
var setURLService = '/service'
var setURLCase = setURLService + '/case'
$(function () {
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
            url: setURLCaseService + "/get-data-case-open-mt",
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
            url: setURLCaseService + "/get-data-case-doing-mt",
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
                data: 'case_status',
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return `
                        <span class="badge bg-label-primary">${row.case_status}</span>
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
    $('.dt-case-openCase').DataTable().ajax.reload(null, false);
    $('.dt-case-working').DataTable().ajax.reload(null, false);
}
$(document).ready(function () {
    scheduleFetch("/case-service/realtime-case-new-count-mt", "caseNewCountMT", 60000); // สำหรับ MT
    scheduleFetch("/case-service/realtime-case-doing-count-mt", "caseDoingCountMT", 60000); // สำหรับ FU
    setInterval(reTable, 60000);
});

function getDetailCase(ticket) {
    $('.dt-approve-history').DataTable().ajax.reload();

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
                    render: badgeStatusTagWork
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
