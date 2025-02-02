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

    var dt_caseCheckWork = $('.dt-caseCheckWork')
    dt_caseCheckWork.DataTable({
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
            url: setURLApprove + "/get-data-caseCheckWork",
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
    // $('.dt-approve-case-it').DataTable().ajax.reload();
    $('.dt-approve-mt').DataTable().ajax.reload(null, false);
    $('.dt-approve-fu').DataTable().ajax.reload(null, false);
    $('.dt-caseCheckWork').DataTable().ajax.reload(null, false);
}
$(document).ready(function () {
    scheduleFetch(setURLApprove + "/realtime-case-approve-count/mt", "caseApproveCountMT", 90000); // สำหรับ MT
    scheduleFetch(setURLApprove + "/realtime-case-approve-count-subset/furniture", "caseApproveCountFU", 90000); // สำหรับ FU
    scheduleFetch(setURLApprove + "/realtime-case-checkwork-count/mt", "caseCheckWorkCount", 90000); // สำหรับ FU
    setInterval(reTable, 90000);
});

function getDetailCase(ticket) {
    // $('.dt-approve-history').DataTable().ajax.reload();

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
