var setURLSettingAssets = '/assets-management/settings-assets'
var setURLAssetsTag = setURLSettingAssets + '/tag'
var setURLAssetsType = setURLSettingAssets + '/type'

$(document).ready(function () {
    $("#saveAssetTag").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddAssetTag")[0];
        const fv = setupFormValidationAssetTag(form);
        const formData = new FormData(form);
        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLAssetsTag + "/save-assets-tag", formData)
                    .done(onSaveAssetTagSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });

    $("#saveAssetType").on("click", function (e) {
        e.preventDefault();
        removeValidationFeedback();
        const form = $("#formAddAssetType")[0];
        const fv = setupFormValidationAssetType(form);
        const formData = new FormData(form);
        fv.validate().then(function (status) {
            if (status === 'Valid') {
                postFormData(setURLAssetsType + "/save-assets-type", formData)
                    .done(onSaveAssetTypeSuccess)
                    .fail(handleAjaxSaveError);
            }
        });
    });
});

function setupFormValidationAssetTag(formElement) {
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
        colorFormat: message => ({
            validators: {
                notEmpty: { message },
                regexp: {
                    regexp: /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/,
                    message: 'กรุณาระบุสีในรูปแบบ #RRGGBB หรือ #RGB'
                }
            }
        })
    };

    const validationRules = {
        asset_tag_name: validators.notEmptyAndRegexp('ระบุชื่อ รายการสินทรัพย์', /^[a-zA-Z0-9ก-๏\s]+$/u),
        asset_tag_color: validators.colorFormat('ระบุค่าสีที่ถูกต้อง'),
        status_tag: validators.notEmpty('เลือกข้อมูล สถานะ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-12, .col-md-6'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function setupFormValidationAssetType(formElement) {
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
        asset_type_name: validators.notEmptyAndRegexp('ระบุชื่อ รายการอุปกรณ์', /^[a-zA-Z0-9ก-๏\s]+$/u),
        assets_tag: validators.notEmpty('เลือกข้อมูล รายการสินทรัพย์'),
        status_type: validators.notEmpty('เลือกข้อมูล สถานะ'),
    };

    return FormValidation.formValidation(formElement, {
        fields: validationRules,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.col-md-12, .col-md-6'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        },
    });
}

function onSaveAssetTagSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addAssetTagModal", "#formAddAssetTag");
}

function onSaveAssetTypeSuccess(response) {
    handleAjaxSaveResponse(response);
    closeAndResetModal("#addAssetTypeModal", "#formAddAssetType");
}