var setURLSettingAssets = '/assets-management/settings-assets'
var setURLAssetsTag = setURLSettingAssets + '/tag'
var setURLAssetsType = setURLSettingAssets + '/type'

$(function () {
    var dt_asstesTag = $('.dt-assetsTag')
    var dt_asstesType = $('.dt-assetsType')
    dt_asstesTag.DataTable({
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
            url: setURLAssetsTag + "/get-data-asstes-tag",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            { 
                data: 'asset_tag_name', 
                class: "text-center",
                render: function(data, type, row) {
                    const color = row.asset_tag_color || '#FFFFFF'; // กำหนดสีเริ่มต้นหากไม่มีค่า
                    return renderAssetsTagBadge(color, data);
                }
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
                    return renderGroupActionButtonsPermission(data, type, row, 'AssetsTag', Permission);
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    dt_asstesType.DataTable({
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
            url: setURLAssetsType + "/get-data-asstes-type",
            type: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            { data: 'asset_type_name', class: "text-center" },
            { 
                data: 'asset_tag_name', 
                class: "text-center",
                render: function(data, type, row) {
                    // console.log(row.asset_tag_color)
                    const color = row.asset_tag_color || '#FFFFFF'; // กำหนดสีเริ่มต้นหากไม่มีค่า
                    return renderAssetsTagBadge(color, data);
                }
            },
            {
                data: "status_type",
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
                    return renderGroupActionButtonsPermission(data, type, row, 'AssetsType', Permission);
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
    $('#addAssetsTag').click(function () {
        showModalWithAjax('#addAssetTagModal', setURLAssetsTag + '/add-assets-tag-modal', ['#status_tag']);
    });

    $('#addAssetsType').click(function () {
        showModalWithAjax('#addAssetTypeModal', setURLAssetsType + '/add-assets-type-modal', ['#status_type','#asset_tag_id']);
    });
});

function reTable() {
    $('.dt-assetsTag').DataTable().ajax.reload();
    $('.dt-assetsType').DataTable().ajax.reload();
}

function funcEditAssetsTag(assetTagID) {
    showModalWithAjax('#editAssetTagModal', setURLAssetsTag + '/show-edit-assets-tag/' + assetTagID, ['#status_tag']);
}

function funcDeleteAssetsTag(assetTagID) {
    handleAjaxDeleteResponse(assetTagID, setURLAssetsTag + "/delete-assets-tag/" + assetTagID);
}

function funcViewAssetsTag(assetTagID) {
    showModalViewWithAjax('#viewAssetTagModal', setURLAssetsTag + '/view-asstes-tag/' + assetTagID, ['#status_tag']);
}