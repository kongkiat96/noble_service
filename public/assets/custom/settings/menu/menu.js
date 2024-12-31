$(function () {
    var dt_Menu_table = $('.dt-settingMenu')
    var dt_Menu_sub_table = $('.dt-settingMenuSub')
    var dt_user_access_menu_table = $('.dt-user-access-menu')

    dt_Menu_table.DataTable({
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
            url: '/settings-system/menu/table-menu',
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
            { data: "menu_name", class: "text-nowrap" },
            {
                data: "menu_icon",
                class: "text-nowrap text-center",
                render: function (data, type, row) {
                    return `<i class='menu-icon tf-icons bx ${data}'></i> `;
                }
            },
            { data: "menu_link", class: "text-nowrap text-center" },
            { data: "menu_sort", searchable: false, class: "text-center" },
            {
                data: "status",
                orderable: false,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                // render: (data, type, row) => renderGroupActionButtons(data, type, row, 'MenuMain',disableButtons)
                render: function (data, type, row) {
                    return renderGroupActionButtons(data, type, row, 'MenuMain');
                }
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    dt_Menu_sub_table.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
        lengthMenu: [50, 75, 100],
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
            url: '/settings-system/menu/table-menu-sub',
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
            { data: "menu_name", class: "text-nowrap" },
            {
                data: "menu_icon",
                orderable: false, searchable: false,
                class: "text-nowrap text-center",
                render: function (data, type, row) {
                    return `<i class='menu-icon tf-icons bx ${data}'></i> `;
                }
            },
            { data: "menu_link", class: "text-nowrap text-center" },
            { data: "menu_sub_name", class: "text-nowrap" },
            {
                data: "menu_sub_icon",
                orderable: false, searchable: false,
                class: "text-nowrap text-center",
                render: function (data, type, row) {
                    return `<i class='menu-icon tf-icons bx ${data}'></i> `;
                }
            },
            { data: "menu_sub_link", class: "text-nowrap text-center" },

            {
                data: "status",
                orderable: false,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },


            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: (data, type, row) => renderGroupActionButtons(data, type, row, 'MenuSub')
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

    dt_user_access_menu_table.DataTable({
        processing: true,
        paging: true,
        pageLength: 50,
        lengthMenu: [50, 75, 100],
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
            url: '/employee/list-all-employee/table-employee-current',
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
            { data: "employee_code", class: "text-nowrap" },
            { data: "email", class: "text-nowrap" },
            { data: "full_name", class: "text-nowrap" },
            { data: "class_name", class: "text-nowrap" },
            { data: "position_name", class: "text-nowrap" },
            { data: "company_name_th", class: "text-nowrap" },
            { data: "department_name", class: "text-nowrap" },
            { data: "group_name", class: "text-nowrap" },
            { data: "user_class", class: "text-nowrap", render: renderUserClassBadge },
            {
                data: "status_login",
                orderable: false,
                searchable: false,
                class: "text-center",
                render: renderStatusBadge
            },
            {
                data: 'ID',
                orderable: false,
                searchable: false,
                class: "text-center",
                render: (data, type, row) => renderGroupActionAccessMenuButtons(data, type, row, 'AccessMenu')
            }
        ],
        columnDefs: [
            {
                targets: 0,
            },
        ],
    });

})

function reTable() {
    $('.dt-settingMenu').DataTable().ajax.reload();
    $('.dt-settingMenuSub').DataTable().ajax.reload();
    $('.dt-user-access-menu').DataTable().ajax.reload();
}
$(document).ready(function () {
    $('#addMenuModal').click(function () {
        showModalWithAjax('#menuMainModal', '/settings-system/menu/menu-modal', ['#statusMenu']);
    });
    $('#addMenuSubModal').click(function () {
        showModalWithAjax('#menuSubModal', '/settings-system/menu/menu-sub-modal', ['#menuMain', '#statusMenu']);
    });

    $('#addAccessMenuModal').click(function () {
        showModalWithAjax('#accessMenuModal', '/settings-system/menu/access-menu-modal', ['#selectUser']);
    });
});

function funcEditMenuMain(menuMainID) {
    showModalWithAjax('#editMenuMainModal', '/settings-system/menu/show-edit-menu-main/' + menuMainID, ['#edit_statusMenu']);
}

function funcDeleteMenuMain(menuMainID) {
    handleAjaxDeleteResponse(menuMainID, "/settings-system/menu/delete-menu-main/" + menuMainID);
}

function funcEditMenuSub(menuSubID) {
    showModalWithAjax('#editMenuSubModal', '/settings-system/menu/show-edit-menu-sub/' + menuSubID, ['#menuMain', '#edit_statusMenu']);
}

function funcDeleteMenuSub(menuSubID) {
    handleAjaxDeleteResponse(menuSubID, "/settings-system/menu/delete-menu-sub/" + menuSubID);
}

function funcAccessMenu(idMapEmployee) {
    // showModalWithAjax('#editMenuSubModal', '/settings-system/menu/show-edit-menu-sub/' + menuSubID, ['#menuMain', '#edit_statusMenu']);
    showModalWithAjax('#accessMenuModal', '/settings-system/menu/access-menu-modal/' + idMapEmployee, []);
}