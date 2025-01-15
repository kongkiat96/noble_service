var setURLService = '/service'
var setURLCase = setURLService + '/case'
var setURLApprove = setURLService + '/approve-case'
$(function () {
    var dt_CaseITAll = $('.dt-case-it-all')
    dt_CaseITAll.DataTable({
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
            url: setURLCase + "/get-data-case-all",
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
                    return `<span class="badge bg-label-primary">${row.ticket}</span>`;
                }
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
                data: 'case_detail',
                class: "text-center",
                render: function (data, type, row) {
                    if (data && data.length > 50) { // เช็คความยาวของข้อความ
                        return data.substring(0, 50) + '...'; // ตัดข้อความเหลือ 20 ตัวอักษร พร้อมใส่ "..." ต่อท้าย
                    }
                    return data; // แสดงข้อความตามปกติหากสั้นกว่า 20 ตัวอักษร
                }
            },
            {
                data: 'created_at',
                class: "text-center",
            },
            {
                data: 'case_status',
                class: "text-center",
                render: badgeStatusTagWork
            },
            {
                data: 'employee_other_case',
                class: "text-center",
            },
            {
                data: 'manager_name',
                class: "text-center",
            },
            {
                data: 'case_start',
                class: "text-center",
            },
            {
                data: 'created_user',
                class: "text-center",
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return renderGroupActionButtonsCaseCheck(data, type, row, 'ViewHistory');
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_CaseMTAll = $('.dt-case-mt-all')
    dt_CaseMTAll.DataTable({
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
            url: setURLCase + "/get-data-case-all",
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
                    return `<span class="badge bg-label-primary">${row.ticket}</span>`;
                }
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
                data: 'case_detail',
                class: "text-center",
                render: function (data, type, row) {
                    if (data && data.length > 50) { // เช็คความยาวของข้อความ
                        return data.substring(0, 50) + '...'; // ตัดข้อความเหลือ 20 ตัวอักษร พร้อมใส่ "..." ต่อท้าย
                    }
                    return data; // แสดงข้อความตามปกติหากสั้นกว่า 20 ตัวอักษร
                }
            },
            {
                data: 'created_at',
                class: "text-center",
            },
            {
                data: 'case_status',
                class: "text-center",
                render: badgeStatusTagWork
            },
            {
                data: 'employee_other_case',
                class: "text-center",
            },
            {
                data: 'manager_name',
                class: "text-center",
            },
            {
                data: 'case_start',
                class: "text-center",
            },
            {
                data: 'created_user',
                class: "text-center",
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return renderGroupActionButtonsCaseCheck(data, type, row, 'ViewHistory');
                }
            }

        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    var dt_CaseCheckWork = $('.dt-case-check-work')
    dt_CaseCheckWork.DataTable({
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
            url: setURLCase + "/get-data-case-check-work",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            // data: function (d) {
            //     return $.extend({}, d, {
            //         "use_tag": "MT",
            //     });
            // }
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
                    return `<span class="badge bg-label-primary">${row.ticket}</span>`;
                }
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
                data: 'case_detail',
                class: "text-center",
                render: function (data, type, row) {
                    if (data && data.length > 50) { // เช็คความยาวของข้อความ
                        return data.substring(0, 50) + '...'; // ตัดข้อความเหลือ 20 ตัวอักษร พร้อมใส่ "..." ต่อท้าย
                    }
                    return data; // แสดงข้อความตามปกติหากสั้นกว่า 20 ตัวอักษร
                }
            },
            {
                data: 'created_at',
                class: "text-center",
            },
            {
                data: 'case_status',
                class: "text-center",
                render: badgeStatusTagWork
            },
            {
                data: 'employee_other_case',
                class: "text-center",
            },
            {
                data: 'manager_name',
                class: "text-center",
            },
            {
                data: 'case_start',
                class: "text-center",
            },
            {
                data: 'created_user',
                class: "text-center",
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    // console.log(row)
                    return renderGroupActionButtonsCaseCheck(data, type, row, 'CheckCaseWork');
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });
})
function reTable(){
    $('.dt-case-it-all').DataTable().ajax.reload(null, false);
    $('.dt-case-mt-all').DataTable().ajax.reload(null, false);
    $('.dt-case-check-work').DataTable().ajax.reload(null, false);
}

$(document).ready(function () {
    $('#btnApproveCaseSubManager').on('click', function () {
        window.location.href = setURLApprove + "/sub-manager";
    })

    scheduleFetch(setURLCase + "/realtime-case-checkwork-byuser-count", "caseCheckWorkByUserAllCount", 60000);
    // scheduleFetch("/service/approve-case/realtime-case-approve-count-fu", "caseApproveCountFU", 60000);
    setInterval(reTable, 60000);
});

function funcCheckCaseWork(caseID) {
    // alert(caseID);
    showModalWithAjax('#checkWorkerModal', setURLCase + '/show-case-check-work/' + caseID, ['#case_status']);
}

function funcViewHistory(caseID) {
    // alert(caseID);
    showModalWithAjax('#checkWorkerModal', setURLCase + '/show-case-history/' + caseID);
}