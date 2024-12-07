<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::middleware(['auth'])->group(function () {
    Route::get('home', 'HomeController@index');

    Route::prefix('/assets-management')->group(function () {


        Route::prefix('/settings-assets')->group(function () {
            Route::get('', 'AssetsManagement\SettingAssetsController@index');

            Route::prefix('/tag')->group(function () {
                Route::post('/get-data-asstes-tag', 'AssetsManagement\SettingAssetsTagController@getDataAssetsTag');
                Route::get('/add-assets-tag-modal', 'AssetsManagement\SettingAssetsTagController@showAddAssetsTagModal');
                Route::post('/save-assets-tag', 'AssetsManagement\SettingAssetsTagController@saveDataAssetsTag');
                Route::get('/show-edit-assets-tag/{assetsTagID}', 'AssetsManagement\SettingAssetsTagController@showEditAssetsTag');
                Route::post('/edit-assets-tag/{assetsTagID}', 'AssetsManagement\SettingAssetsTagController@editAssetsTag');
                Route::post('/delete-assets-tag/{assetsTagID}', 'AssetsManagement\SettingAssetsTagController@deleteAssetsTag');
                Route::get('/view-asstes-tag/{assetTagID}', 'AssetsManagement\SettingAssetsTagController@showAsstesTag');
            });

            Route::prefix('/type')->group(function () {
                Route::post('/get-data-asstes-type', 'AssetsManagement\SettingAssetsTypeController@getDataAssetsType');
                Route::get('/add-assets-type-modal', 'AssetsManagement\SettingAssetsTypeController@showAddAssetsTypeModal');
                Route::post('/save-assets-type', 'AssetsManagement\SettingAssetsTypeController@saveDataAssetsType');
                Route::get('/show-edit-assets-type/{assetsTypeID}', 'AssetsManagement\SettingAssetsTypeController@showEditAssetsType');
                Route::post('/edit-assets-type/{assetsTypeID}', 'AssetsManagement\SettingAssetsTypeController@editAssetsType');
                Route::post('/delete-assets-type/{assetsTypeID}', 'AssetsManagement\SettingAssetsTypeController@deleteAssetsType');
                Route::get('/view-asstes-type/{assetTypeID}', 'AssetsManagement\SettingAssetsTypeController@showAsstesType');
            });
        });
    });

    Route::prefix('employee')->group(function () {
        Route::prefix('/list-all-employee')->group(function () {
            Route::get('', 'Employee\EmployeeController@getAllEmployee');
            Route::get('/table-employee-current', 'Employee\EmployeeController@showDataEmployeeCurrent');
            Route::get('/table-employee-disable', 'Employee\EmployeeController@showDataEmployeeDisable');
        });

        Route::prefix('/search-all-employee')->group(function () {
            Route::get('', 'Employee\EmployeeController@searchEmployee');
        });

        Route::post('/delete-employee/{employeeID}', 'Employee\EmployeeController@deleteEmployee');

        Route::prefix('/edit-employee')->group(function () {
            Route::get('/show-edit-employee/{employeeID}', 'Employee\EmployeeController@showEditEmployee');
            Route::post('/save-edit-employee/{employeeID}', 'Employee\EmployeeController@editEmployee');
        });


        Route::prefix('/add-employee')->group(function () {
            Route::get('', 'Employee\EmployeeController@addEmployee');
            Route::post('/save-employee', 'Employee\EmployeeController@saveEmployee');
        });
    });

    Route::prefix('/document')->group(function () {
        Route::prefix('/invoice')->group(function () {
            Route::get('', 'Document\InvoiceController@index');
            Route::post('/table-invoice', 'Document\InvoiceController@getDataInvoice');
            Route::get('/search-month/{searchMonth}/{tagSearch}', 'Document\InvoiceController@showDataSearchMonth');
            Route::post('/table-search-invoice', 'Document\InvoiceController@getDataSearchInvoice');

            Route::get('/create-invoice', 'Document\InvoiceController@createInvoice')->name('create-invoice');
            Route::get('/created-invoice/{id}', 'Document\InvoiceController@createdInvoice')->name('created-invoice');
            Route::post('/add-detail-invoice', 'Document\InvoiceController@addDetailInvoice');
            Route::delete('/delete-detail-invoice/{id}', 'Document\InvoiceController@deleteDetailInvoice');

            Route::post('/save-invoice', 'Document\InvoiceController@saveDataInvoice');
            Route::post('/save-invoice-drawing', 'Document\InvoiceController@saveDrawingInvoice');
            Route::get('/view-invoice/{id}', 'Document\InvoiceController@viewInvoice')->name('view-invoice');
            Route::post('/delete-invoice/{id}', 'Document\InvoiceController@deleteInvoice');

            Route::get('/print-invoice/{id}', 'Document\InvoiceController@printInvoice');
            Route::get('/print-receipt/{id}', 'Document\InvoiceController@printReceipt');
        });
    });

    Route::prefix('/evaluation')->group(function () {
        Route::prefix('/form-department')->group(function () {
            Route::get('', 'Evaluation\FormDepartmentController@index')->name('form-department');

            Route::get('/add-form-department-modal', 'Evaluation\FormDepartmentController@showAddFormDepartmentModal');
            Route::post('/save-select-employee', 'Evaluation\FormDepartmentController@saveSelectEmployee');
            Route::get('/show-evaluation/{id}', 'Evaluation\FormDepartmentController@showEvaluation');
        });
    });

    Route::prefix('settings-system')->group(function () {
        Route::prefix('/work-status')->group(function () {
            Route::get('', 'Settings\SetStatusController@index');

            Route::get('/status-modal', 'Settings\SetStatusController@showStatusModal');
            Route::get('/flag-type-modal', 'Settings\SetStatusController@showFlagTypeModal');

            Route::get('/table-status', 'Settings\SetStatusController@showDataStatus');
            Route::get('/table-flag-type', 'Settings\SetStatusController@showDataFlagType');

            Route::post('/save-status', 'Settings\SetStatusController@saveDataStatus');
            Route::get('/show-edit-status/{statusID}', 'Settings\SetStatusController@showEditStatus');
            Route::post('/edit-status/{statusID}', 'Settings\SetStatusController@editStatus');
            Route::post('/delete-status/{statusID}', 'Settings\SetStatusController@deleteStatus');

            Route::post('/save-flag-type', 'Settings\SetStatusController@saveDataFlagType');
            Route::get('/show-edit-flag-type/{flagTypeID}', 'Settings\SetStatusController@showEditFlagType');
            Route::post('/edit-flag-type/{flagTypeID}', 'Settings\SetStatusController@editFlagType');
            Route::post('/delete-flag-type/{flagTypeID}', 'Settings\SetStatusController@deleteFlagType');
        });

        Route::prefix('/menu')->group(function () {
            Route::get('', 'Settings\MenuController@index');
            Route::get('/menu-modal', 'Settings\MenuController@showMenuModal');
            Route::get('/menu-sub-modal', 'Settings\MenuController@showMenuSubModal');
            Route::get('/access-menu-modal/{idMapEmployee}', 'Settings\MenuController@showAccessMenuModal');

            Route::post('/save-menu-main', 'Settings\MenuController@saveDataMenuMain');
            Route::get('/show-edit-menu-main/{menuMainID}', 'Settings\MenuController@showEditMenuMain');
            Route::post('/edit-menu-main/{menuMainID}', 'Settings\MenuController@editMenuMain');
            Route::post('/delete-menu-main/{menuMainID}', 'Settings\MenuController@deleteMenuMain');

            Route::post('/save-menu-sub', 'Settings\MenuController@saveDataMenuSub');
            Route::get('/show-edit-menu-sub/{menuSubID}', 'Settings\MenuController@showEditMenuSub');
            Route::post('/edit-menu-sub/{menuSubID}', 'Settings\MenuController@editMenuSub');
            Route::post('/delete-menu-sub/{menuSubID}', 'Settings\MenuController@deleteMenuSub');

            Route::post('/save-access-menu', 'Settings\MenuController@saveDataAccessMenu');

            Route::get('/table-menu', 'Settings\MenuController@showDataMenu');
            Route::get('/table-menu-sub', 'Settings\MenuController@showDataMenuSub');
        });

        Route::prefix('/about-company')->group(function () {
            Route::get('', 'Settings\AboutCompanyController@index');

            Route::get('/company-modal', 'Settings\AboutCompanyController@showCompanyModal');
            Route::get('/department-modal', 'Settings\AboutCompanyController@showDepartmentModal');
            Route::get('/group-modal', 'Settings\AboutCompanyController@showGroupModal');
            Route::get('/prefix-name-modal', 'Settings\AboutCompanyController@showPrefixNameModal');
            Route::get('/class-list-modal', 'Settings\AboutCompanyController@showClassListModal');

            Route::get('/table-company', 'Settings\AboutCompanyController@showDataCompany');
            Route::get('/table-department', 'Settings\AboutCompanyController@showDataDepartment');
            Route::get('/table-group', 'Settings\AboutCompanyController@showDataGroup');
            Route::get('/table-prefix-name', 'Settings\AboutCompanyController@showDataPrefixName');
            Route::get('/table-class-list', 'Settings\AboutCompanyController@showDataClassList');

            Route::post('/save-company', 'Settings\AboutCompanyController@saveDataCompany');
            Route::get('/show-edit-company/{companyID}', 'Settings\AboutCompanyController@showEditCompany');
            Route::post('/edit-company/{companyID}', 'Settings\AboutCompanyController@editCompany');
            Route::post('/delete-company/{companyID}', 'Settings\AboutCompanyController@deleteCompany');

            Route::post('/save-department', 'Settings\AboutCompanyController@saveDataDepartment');
            Route::get('/show-edit-department/{departmentID}', 'Settings\AboutCompanyController@showEditDepartment');
            Route::post('/edit-department/{departmentID}', 'Settings\AboutCompanyController@editDepartment');
            Route::post('/delete-department/{departmentID}', 'Settings\AboutCompanyController@deleteDepartment');

            Route::post('/save-group', 'Settings\AboutCompanyController@saveDataGroup');
            Route::get('/show-edit-group/{groupID}', 'Settings\AboutCompanyController@showEditGroup');
            Route::post('/edit-group/{groupID}', 'Settings\AboutCompanyController@editGroup');
            Route::post('/delete-group/{groupID}', 'Settings\AboutCompanyController@deleteGroup');

            Route::post('/save-prefix-name', 'Settings\AboutCompanyController@saveDataPrefixName');
            Route::get('/show-edit-prefix-name/{prefixNameID}', 'Settings\AboutCompanyController@showEditPrefixName');
            Route::post('/edit-prefix-name/{prefixNameID}', 'Settings\AboutCompanyController@editPrefixName');
            Route::post('/delete-prefix-name/{prefixNameID}', 'Settings\AboutCompanyController@deletePrefixName');

            Route::post('/save-class-list', 'Settings\AboutCompanyController@saveDataClassList');
            Route::get('/show-edit-class-list/{classListID}', 'Settings\AboutCompanyController@showEditClassList');
            Route::post('/edit-class-list/{classListID}', 'Settings\AboutCompanyController@editClassList');
            Route::post('/delete-class-list/{classListID}', 'Settings\AboutCompanyController@deleteClassList');
        });

        Route::prefix('/about-app')->group(function () {
            Route::get('', 'Settings\AboutAppController@index');
            Route::post('/save-about-app', 'Settings\AboutAppController@saveAboutAppData');
        });

        Route::prefix('/set-type-category-it')->group(function () {
            Route::get('', 'Settings\SetTypeCategoryController@index_it');
            Route::get('/add-category-main-modal', 'Settings\SetTypeCategoryController@showAddCategoryMainModal');
            Route::get('/add-category-type-modal', 'Settings\SetTypeCategoryController@showAddCategoryTypeModal');
            Route::get('/add-category-detail-modal', 'Settings\SetTypeCategoryController@showAddCategoryDetailModal');
        });

        Route::prefix('/set-type-category-mt')->group(function () {
            Route::get('', 'Settings\SetTypeCategoryController@index_mt');
            Route::get('/add-category-main-modal', 'Settings\SetTypeCategoryController@showAddCategoryMainModal_mt');
            Route::get('/add-category-type-modal', 'Settings\SetTypeCategoryController@showAddCategoryTypeModal_mt');
            Route::get('/add-category-detail-modal', 'Settings\SetTypeCategoryController@showAddCategoryDetailModal_mt');
        });

        Route::prefix('/set-type-category-tools')->group(function () {
            Route::post('/save-category-main', 'Settings\SetTypeCategoryController@saveCategoryMain');
            Route::get('/show-edit-category-main/{categoryMainID}', 'Settings\SetTypeCategoryController@showEditCategoryMain');
            Route::post('/edit-category-main/{categoryMainID}', 'Settings\SetTypeCategoryController@editCategoryMain');
            Route::post('/delete-category-main/{categoryMainID}', 'Settings\SetTypeCategoryController@deleteCategoryMain');

            Route::post('/save-category-type', 'Settings\SetTypeCategoryController@saveCategoryType');
            Route::get('/show-edit-category-type/{categoryTypeID}', 'Settings\SetTypeCategoryController@showEditCategoryType');
            Route::post('/edit-category-type/{categoryTypeID}', 'Settings\SetTypeCategoryController@editCategoryType');
            Route::post('/delete-category-type/{categoryTypeID}', 'Settings\SetTypeCategoryController@deleteCategoryType');

            Route::post('/save-category-detail', 'Settings\SetTypeCategoryController@saveCategoryDetail');
            Route::get('/show-edit-category-detail/{categoryDetailID}', 'Settings\SetTypeCategoryController@showEditCategoryDetail');
            Route::post('/edit-category-detail/{categoryDetailID}', 'Settings\SetTypeCategoryController@editCategoryDetail');
            Route::post('/delete-category-detail/{categoryDetailID}', 'Settings\SetTypeCategoryController@deleteCategoryDetail');

            Route::post('/get-data-category-main', 'Settings\SetTypeCategoryController@getDataCategoryMain');
            Route::post('/get-data-category-type', 'Settings\SetTypeCategoryController@getDataCategoryType');
            Route::post('/get-data-category-detail', 'Settings\SetTypeCategoryController@getDataCategoryDetail');

            Route::get('/set-detail-category/{encryptID}', 'Settings\SetTypeCategoryController@setDetailCategory');
            Route::get('/add-category-item-modal/{categoryAllID}', 'Settings\SetTypeCategoryController@showAddCategoryItemModal');
            Route::post('/save-category-item', 'Settings\SetTypeCategoryController@saveCategoryItem');
            Route::get('/show-edit-category-item/{categoryItemID}', 'Settings\SetTypeCategoryController@showEditCategoryItem');
            Route::post('/edit-category-item/{categoryItemID}', 'Settings\SetTypeCategoryController@editCategoryItem');
            Route::post('/delete-category-item/{categoryItemID}', 'Settings\SetTypeCategoryController@deleteCategoryItem');

            Route::get('/add-category-list-modal/{categoryAllID}', 'Settings\SetTypeCategoryController@showAddCategoryListModal');
            Route::post('/save-category-list', 'Settings\SetTypeCategoryController@saveCategoryList');
            Route::get('/show-edit-category-list/{categoryListID}', 'Settings\SetTypeCategoryController@showEditCategoryList');
            Route::post('/edit-category-list/{categoryListID}', 'Settings\SetTypeCategoryController@editCategoryList');
            Route::post('/delete-category-list/{categoryListID}', 'Settings\SetTypeCategoryController@deleteCategoryList');

            Route::post('/get-data-category-item', 'Settings\SetTypeCategoryController@getDataCategoryItem');
            Route::post('/get-data-category-list', 'Settings\SetTypeCategoryController@getDataCategoryList');
        });

        Route::prefix('/checker')->group(function () {
            Route::get('', 'Settings\CheckerController@index');
            Route::get('/add-checker-modal', 'Settings\CheckerController@showAddCheckerModal');
            Route::post('/save-checker', 'Settings\CheckerController@saveCheckerData');
            Route::get('/show-edit-checker/{checkerID}', 'Settings\CheckerController@showEditChecker');
            Route::post('/edit-checker/{checkerID}', 'Settings\CheckerController@saveEditChecker');
            Route::post('/delete-checker/{checkerID}', 'Settings\CheckerController@deleteChecker');

            Route::post('/get-data-checker', 'Settings\CheckerController@getDataChecker');
        });
    });

    Route::prefix('getMaster')->group(function () {
        Route::get('/get-company/{id}', 'Master\getDataMasterController@getDataCompany');
        Route::get('/get-department/{id}', 'Master\getDataMasterController@getDataDepartment');
        Route::get('/get-group/{id}', 'Master\getDataMasterController@getDataGroup');
        Route::get('/get-prefix-name', 'Master\getDataMasterController@getDataPrefixName');
        Route::get('/get-province', 'Master\getDataMasterController@getDataProvince');
        Route::get('/get-amphoe/{provinceID}', 'Master\getDataMasterController@getDataAmphoe');
        Route::get('/get-tambon/{aumphoeID}', 'Master\getDataMasterController@getDataTambon');
        Route::get('/get-category-type/{categoryMainID}', 'Master\getDataMasterController@getDataCategoryType');
    });

    Route::prefix('test')->group(function () {
        Route::post('', 'Test\KongkiatController@index');
    });
});


//Clear route cache:
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});
