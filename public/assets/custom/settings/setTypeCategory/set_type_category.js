var setURLSetting = '/settings-system'
var setURLCategoryIT = setURLSetting + '/set-type-category-it'
var setURLCategoryMT = setURLSetting + '/set-type-category-mt'
var setURLCategoryTools = setURLSetting + '/set-type-category-tools'

$(function () {
    var dt_CategoryMain = $('.dt-category-main')
    var dt_asstesType = $('.dt-assetsType')
    dt_CategoryMain.DataTable({
        processing: true,
        paging: true,
        pageLength: 10,
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
            url: setURLCategoryTools + "/get-data-category-main",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: function (d) {
                return $.extend({}, d, {
                    "use_tag": $("#show_use_tag").val(),
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
                data: 'category_main_name', 
                class: "text-center",
            },
            {
                data: "status_tag",
                orderable: true,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },
            { data: 'created_at', class: "text-center" },
            { data: 'created_user', class: "text-center" },
            { data: 'updated_at', class: "text-center" },
            { data: 'updated_user', class: "text-center" },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'CategoryMain', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });
});

$(document).ready(function () {
    $('#addCategoryMain').click(function () {
        showModalWithAjax('#addCategoryMainModal', setURLCategoryIT + '/add-category-main-modal', ['#status_tag']);
    });
    $('#addCategoryType').click(function () {
        showModalWithAjax('#addCategoryTypeModal', setURLCategoryIT + '/add-category-type-modal', ['#category_main','#status_tag']);
    });
});

function reTable() {
    $('.dt-category-main').DataTable().ajax.reload();
    // $('.dt-assetsType').DataTable().ajax.reload();
}

function funcEditCategoryMain(categoryMainID) {
    showModalWithAjax('#editCategoryMainModal', setURLCategoryTools + '/show-edit-category-main/' + categoryMainID, ['#status_tag']);
}

function funcDeleteCategoryMain(categoryMainID) {
    handleAjaxDeleteResponse(categoryMainID, setURLCategoryTools + "/delete-category-main/" + categoryMainID);
}

// function funcViewCategoryMain(categoryMainID) {
//     showModalViewWithAjax('#viewAssetTagModal', setURLCategoryTools + '/view-category-main/' + categoryMainID, ['#status_tag']);
// }

function setupFormValidationCategoryMain(formElement) {
    const validators = {
        notEmpty: message => ({
            validators: {
                notEmpty: { message }
            }
        }),
        notEmptyAndRegexp: (message, regexp) => ({
            validators: {
                notEmpty: { message },
                regexp: { regexp, message: 'ข้อมูลไม่ถูกต้อง' }
            }
        }),
    };

    const validationRules = {
        category_main_name: validators.notEmptyAndRegexp('ระบุชื่อ รายการอุปกรณ์', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        status_tag: validators.notEmpty('เลือกข้อมูล สถานะ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-6'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}