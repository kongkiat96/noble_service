var setURLSetting = '/settings-system'
var setURLCategoryIT = setURLSetting + '/set-type-category-it'
var setURLCategoryMT = setURLSetting + '/set-type-category-mt'
var setURLCategoryTools = setURLSetting + '/set-type-category-tools'

$(function () {
    var dt_CategoryMain = $('.dt-category-main')
    var dt_CategoryType = $('.dt-category-type')
    var dt_CategoryDetail = $('.dt-category-detail')
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

    dt_CategoryType.DataTable({
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
            url: setURLCategoryTools + "/get-data-category-type",
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
                data: 'category_type_name', 
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
                    return renderGroupActionButtonsPermission(data, type, row, 'CategoryType', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    dt_CategoryDetail.DataTable({
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
            url: setURLCategoryTools + "/get-data-category-detail",
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
                data: 'category_type_name', 
                class: "text-center",
            },
            { 
                data: 'category_detail_name', 
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
                    // console.log(row)
                    return setDetailCategory(data, type, row, 'SetDetailCategory');
                }
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: function (data, type, row) {
                    const Permission = (row.Permission);
                    return renderGroupActionButtonsPermission(data, type, row, 'CategoryDetail', Permission);
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
        showModalWithAjax('#addCategoryTypeModal', setURLCategoryIT + '/add-category-type-modal', ['#category_main_id','#status_tag']);
    });

    $('#addCategoryDetail').click(function () {
        showModalWithAjax('#addCategoryDetailModal', setURLCategoryIT + '/add-category-detail-modal', ['#category_main_id','#category_type_id','#status_tag']);
    });

    $('#addCategoryMain_mt').click(function () {
        showModalWithAjax('#addCategoryMainModal', setURLCategoryMT + '/add-category-main-modal', ['#status_tag']);
    });
    $('#addCategoryType_mt').click(function () {
        showModalWithAjax('#addCategoryTypeModal', setURLCategoryMT + '/add-category-type-modal', ['#category_main_id','#status_tag']);
    });

    $('#addCategoryDetail_mt').click(function () {
        showModalWithAjax('#addCategoryDetailModal', setURLCategoryMT + '/add-category-detail-modal', ['#category_main_id','#category_type_id','#status_tag']);
    });
});

function reTable() {
    $('.dt-category-main').DataTable().ajax.reload();
    $('.dt-category-type').DataTable().ajax.reload();
    $('.dt-category-detail').DataTable().ajax.reload();
}

function funcEditCategoryMain(categoryMainID) {
    showModalWithAjax('#editCategoryMainModal', setURLCategoryTools + '/show-edit-category-main/' + categoryMainID, ['#status_tag']);
}

function funcEditCategoryType(categoryTypeID) {
    showModalWithAjax('#editCategoryTypeModal', setURLCategoryTools + '/show-edit-category-type/' + categoryTypeID, ['#category_main_id','#status_tag']);
}

function funcEditCategoryDetail(categoryDetailID) {
    showModalWithAjax('#editCategoryDetailModal', setURLCategoryTools + '/show-edit-category-detail/' + categoryDetailID, ['#category_main_id','#category_type_id','#status_tag']);
}

function funcDeleteCategoryMain(categoryMainID) {
    handleAjaxDeleteResponse(categoryMainID, setURLCategoryTools + "/delete-category-main/" + categoryMainID);
}

function funcDeleteCategoryType(categoryTypeID) {
    handleAjaxDeleteResponse(categoryTypeID, setURLCategoryTools + "/delete-category-type/" + categoryTypeID);
}

function funcDeleteCategoryDetail(categoryDetailID) {
    handleAjaxDeleteResponse(categoryDetailID, setURLCategoryTools + "/delete-category-detail/" + categoryDetailID);
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

function setupFormValidationCategoryType(formElement) {

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
        category_type_name: validators.notEmptyAndRegexp('ระบุชื่อ ประเภทหมวดหมู่', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        category_main_id: validators.notEmpty('เลือกข้อมูล รายการอุปกรณ์'),
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

function setupFormValidationCategoryDetail(formElement) {

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
        category_detail_name: validators.notEmptyAndRegexp('ระบุชื่อ อาการแจ้งซ่อม', /^[a-zA-Z0-9ก-๏\s\(\)\[\]\-\''\/]+$/),
        category_main_id: validators.notEmpty('เลือกข้อมูล รายการอุปกรณ์'),
        category_type_id: validators.notEmpty('เลือกข้อมูล รายการประเภทหมวดหมู่'),
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

function setDetailCategory(data, type, row, useFunc) {
    // console.log(data)
    // console.log(type)
    const func = `func${useFunc}`;
    return `
    <button type="button" class="btn btn-icon btn-label-success btn-success" onclick="${func}(${row.ID})">
        <span class="tf-icons bx bx-sitemap"></span>
    </button>
`;
}

function funcSetDetailCategory(categoryDetailID) {
    alert(categoryDetailID)
    // handleAjaxDeleteResponse(categoryDetailID, setURLCategoryTools + "/delete-category-detail/" + categoryDetailID);
}