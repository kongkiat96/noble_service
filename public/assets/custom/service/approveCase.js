var setURLService = '/service'
var setURLCase = setURLService + '/case'
var setURLApprove = setURLService + '/approve-case'
$(function () {
    var dt_ApproveCaseIT = $('.dt-approve-case-it')
    dt_ApproveCaseIT.DataTable({
        processing: true,
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
            url: setURLApprove + "/get-data-case-all",
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

    var dt_ApproveCaseMT = $('.dt-approve-case-mt')
    dt_ApproveCaseMT.DataTable({
        processing: true,
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
            url: setURLApprove + "/get-data-case-all",
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
})
function reTable() {
    $('.dt-approve-case-it').DataTable().ajax.reload();
    $('.dt-approve-case-mt').DataTable().ajax.reload();
}

function getDetailCase(ticket) {
    $.ajax({
        type: 'GET',
        url: setURLCase + "/get-detail-case/" + ticket,
    }).done(function (data) {
        $('#ticket-detail').html(data);
        $('.select2').select2({
            placeholder: "เลือกข้อมูล"
        });
        const textarea = document.querySelectorAll('textarea')
        if (textarea) {
            autosize(textarea);
        }
    }).fail(function (data) {
        console.log(data)
        Swal.fire({
            icon: 'error',
            text: 'เกิดข้อผิดพลาดในการแสดงข้อมูล',
            showConfirmButton: true,
        });
    });
}

$(document).ready(function () {
    $('#approveCaseManager').on('click', function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formApproveManager")[0];
        const caseID = $('#caseID').val();
        const fv = setupFormValidationApproveCase(form);
        const formData = new FormData(form);

        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLApprove + "/approve-case-manager/" + caseID, formData)
                    .done(onSaveApproveCaseSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    })

    
});



function setupFormValidationApproveCase(formElement, setSelect) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
    };
    const validationRules = {
        case_status: validators.notEmpty('เลือกข้อมูล สถานะการอนุมัติ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-12'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function onSaveApproveCaseSuccess(response) {

    if (response.status === 200) {
        Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลสำเร็จ',
            confirmButtonText: 'ตกลง'
        }).then((result) => {
            window.location.reload();
        });
    } else {
        Swal.fire({
            icon: 'error',
            text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        })
    }
}

$(document).ready(function () {
    scheduleFetch(setURLApprove + "/realtime-case-approve-count/managet-approve-user-it", "caseApproveUserIT", 90000);
    scheduleFetch(setURLApprove + "/realtime-case-approve-count/managet-approve-user-mt", "caseApproveUserMT", 90000);
    setInterval(reTable, 90000);
});