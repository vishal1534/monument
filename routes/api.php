<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CemeteryCategoryController;
use App\Http\Controllers\CemeteryController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\CollaboratorTypeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompositeCategoryController;
use App\Http\Controllers\CompositeController;
use App\Http\Controllers\CorrespondenceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DeliveryWorkOrderController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\InstallationProductionController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\LoaderController;
use App\Http\Controllers\MaintenanceWorkOrderController;
use App\Http\Controllers\MonumentColorController;
use App\Http\Controllers\MonumentController;
use App\Http\Controllers\MonumentPolishController;
use App\Http\Controllers\MonumentShapeController;
use App\Http\Controllers\MonumentSideController;
use App\Http\Controllers\MonumentTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderInstallationController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaperLocationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PoOrderController;
use App\Http\Controllers\PorcelainController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProductionLaserController;
use App\Http\Controllers\ProductionOcPictureController;
use App\Http\Controllers\ProductionSandblastingController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SimpleCategoryController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\userRolesController;
use App\Http\Controllers\UserRoutesLinkController;
use App\Http\Controllers\WeeklyScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostPSqureFeetController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\TaskCollaborationReportController;
use App\Http\Controllers\WorkOrderCollaboratorsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});
Route::post('register', [UserController::class, 'register']);
Route::get('user/user_role',[UserController::class,'updateUserRole']);
Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
Route::post('forgetPassword', [UserController::class, 'forgetPassword']);
Route::post('resetPassword', [UserController::class, 'resetPassword']);
Route::post('verifyUser', [UserController::class, 'verifyUser']);
Route::post('createPassword', [UserController::class, 'createPassword']);

Route::middleware(['api', 'auth:sanctum'])->group(function () {

    /**
     * PO routes
     */
    Route::prefix('PoOrder')->group(function () {
        Route::middleware('permission:Purchasing,read')->get('paginateRecord', [PoOrderController::class, 'paginationRecord']);
        Route::middleware('permission:Purchasing,read')->get('getDropDownRecord', [PoOrderController::class, 'dropDownInfo']);
        Route::middleware('permission:Purchasing,read')->get('next/{poOrder}', [PoOrderController::class, 'getNext']);
        Route::middleware('permission:Purchasing,read')->get('previous/{poOrder}', [PoOrderController::class, 'getPrevious']);
        Route::middleware('permission:Purchasing,read')->get('first', [PoOrderController::class, 'getFirst']);
        Route::middleware('permission:Purchasing,read')->get('last', [PoOrderController::class, 'getLast']);
        Route::middleware('permission:Purchasing,read')->get('columns', [PoOrderController::class, 'getColumns']);
        Route::middleware('permission:Purchasing,read')->post('search', [PoOrderController::class, 'search']);
        Route::middleware('permission:Purchasing,read')->post('updateMInventory', [PoOrderController::class, 'updateMonumentInventory']);
        Route::middleware('permission:Purchasing,read')->post('searchProducts', [PoOrderController::class, 'searchProducts']);
        Route::middleware('permission:Purchasing,delete')->post('deleteProduct/{product}', [PoOrderController::class, 'deleteProduct']);
    });
    Route::middleware('permission:Purchasing,resource')->resource('PoOrder', PoOrderController::class);

    /**
     * User Routes
     * */
    Route::get('userDetail', [UserController::class, 'userDetail']);
    Route::post('updateProfile', [UserController::class, 'updateProfile']);

    /**
     * Accounting Routes --retain pagination routes
     * */
    Route::group([
        'middleware' => 'permission:Accounting,read',
        'prefix' => 'accounting'
    ], function () {
        Route::get('paginateRecord', [AccountingController::class, 'paginateRecord']);
        Route::get('getDropDownRecord', [AccountingController::class, 'getDropDownRecord']);
        Route::get('columns', [AccountingController::class, 'getColumns']);
        Route::post('search', [AccountingController::class, 'search']);
        Route::get('next/{accounting}', [AccountingController::class, 'next']);
        Route::get('previous/{accounting}', [AccountingController::class, 'previous']);
        Route::get('first', [AccountingController::class, 'first']);
        Route::get('last', [AccountingController::class, 'last']);
    });
    Route::middleware('permission:Accounting,resource')->resource('accounting', AccountingController::class);


    /**
     * Composite Routes
     * */
    Route::prefix('composite')->group(function () {
        Route::middleware('permission:Products,read')->get('dropDown', [CompositeController::class, 'getDropDown']);
        Route::middleware('permission:Products,read')->get('next/{composite}', [CompositeController::class, 'getNextPrevious']);
        Route::middleware('permission:Products,read')->get('paginateRecord', [CompositeController::class, 'getRecordPagination']);
        Route::middleware('permission:Products,read')->get('/info', [CompositeController::class, 'compositeInfo']);
        Route::middleware('permission:Products,read')->get('columns', [CompositeController::class, 'getColumns']);
        Route::middleware('permission:Products,read')->post('searchProducts', [CompositeController::class, 'searchProducts']);
        Route::middleware('permission:Products,read')->post('search', [CompositeController::class, 'search']);
        Route::middleware('permission:Products,delete')->post('deleteProduct/{product}', [CompositeController::class, 'deleteProduct']);
        Route::middleware('permission:Products,delete')->post('deleteFile/{document}', [CompositeController::class, 'deleteFile']);
    });
    Route::middleware('permission:Products,read')->resource('composite', CompositeController::class);

    /**
     *  Composite Category Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'compositeCategory'
    ], function () {
        Route::get('columns', [CompositeCategoryController::class, 'getColumns']);
        Route::post('search', [CompositeCategoryController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('compositeCategory', CompositeCategoryController::class);


    /**
     * Cemetery Routes
     * */
    Route::group([
        'middleware' => 'permission:Cemetery,read',
        'prefix' => 'cemetery'
    ], function () {
        Route::get('paginateRecord', [CemeteryController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [CemeteryController::class, 'dropDownInfo']);
        Route::get('next/{cemetery}', [CemeteryController::class, 'getNext']);
        Route::get('previous/{cemetery}', [CemeteryController::class, 'getPrevious']);
        Route::get('first', [CemeteryController::class, 'getFirst']);
        Route::get('last', [CemeteryController::class, 'getLast']);
        Route::get('/info/{id}', [CemeteryController::class, 'cemeteryInfo']);
        Route::post('cityInfo/{id}', [CemeteryController::class, 'cemeteryCityInfo']);
        Route::get('/companies', [CemeteryController::class, 'showCompanies']);
        Route::get('/company', [CemeteryController::class, 'findCompany']);
        Route::get('columns', [CemeteryController::class, 'getColumns']);
        Route::post('search', [CemeteryController::class, 'search']);
        Route::post('deleteFile/{document}', [CemeteryController::class, 'deleteFile']);
        Route::post('category', [CemeteryController::class, 'saveCategory']);
        Route::delete('category/{cemeteryCategory}', [CemeteryController::class, 'deleteCategory']);
    });
    Route::middleware('permission:Cemetery,resource')->resource('cemetery', CemeteryController::class);

    /**
     * Cemetery Category Routes
     */
    Route::group([
        'middleware' => 'permission:Cemetery,read',
        'prefix' => 'cemeteryCategory'
    ], function () {
        Route::get('columns', [CemeteryCategoryController::class, 'getColumns']);
        Route::post('search', [CemeteryCategoryController::class, 'search']);
    });
    Route::middleware('permission:Cemetery,resource')->resource('cemeteryCategory', CemeteryCategoryController::class);

    /**
     * Collaboration Routes
     * */
    Route::prefix('collaboration')->group(function () {
        Route::middleware('permission:Collaboration,read')->get('paginateRecord', [CollaborationController::class, 'getRecordPagination']);
        Route::middleware('permission:Collaboration,read')->get('getDropDownRecord', [CollaborationController::class, 'getDropDownRecord']);
        Route::middleware('permission:Collaboration,read')->get('next/{collaboration}', [CollaborationController::class, 'getNext']);
        Route::middleware('permission:Collaboration,read')->get('previous/{collaboration}', [CollaborationController::class, 'getPrevious']);
        Route::middleware('permission:Collaboration,read')->get('first', [CollaborationController::class, 'getFirst']);
        Route::middleware('permission:Collaboration,read')->get('last', [CollaborationController::class, 'getLast']);
        Route::middleware('permission:Collaboration,read')->get('columns', [CollaborationController::class, 'getColumns']);
        Route::middleware('permission:Collaboration,read')->get('collaboratorTypes', [CollaborationController::class, 'collaboratorTypes']);
        Route::middleware('permission:Collaboration,read')->post('collaboratorTypes', [CollaborationController::class, 'getCollaboratorTypes']);
        Route::middleware('permission:Collaboration,read')->post('search', [CollaborationController::class, 'search']);
        Route::middleware('permission:Collaboration,read')->post('saveCollaborator', [CollaborationController::class, 'saveCollaborator']);
        Route::middleware('permission:Collaboration,delete')->post('deleteTask/{task}', [CollaborationController::class, 'deleteTask']);
        Route::post('uploadImage', [CollaborationController::class, 'uploadImage']);
        Route::middleware('permission:Collaboration,create')->post('updateImage', [CollaborationController::class, 'updateImage']);
        Route::middleware('permission:Collaboration,delete')->post('deleteFile/{id}', [CollaborationController::class, 'deleteFile']);
        Route::post('mail', [CollaborationController::class, 'sendMail']);
        Route::post('sendApprovalMail', [CollaborationController::class, 'sendApprovalMail']);
        Route::post('sendCustomerViewMail', [CollaborationController::class, 'sendCustomerViewMail']);
        Route::post('encodeDecodeData', [CollaborationController::class, 'encodeDecodeData']);
        Route::middleware('permission:Collaboration,delete')->post('deleteOrderLog', [CollaborationController::class, 'deleteLogs']);
    });
    Route::middleware('permission:Collaboration,resource')->resource('collaboration', CollaborationController::class);

    /**
     * Collaborator Routes
     */
    Route::prefix('collaborator')->group(function () {
        Route::middleware('permission:Collaboration,read')->get('paginateRecord', [CollaboratorsController::class, 'paginationRecord']);
        Route::middleware('permission:Collaboration,read')->get('getDropDownRecord', [CollaboratorsController::class, 'dropDownInfo']);
        Route::middleware('permission:Collaboration,read')->get('next/{collaborator}', [CollaboratorsController::class, 'getNextPrevious']);
        Route::middleware('permission:Collaboration,read')->get('previous/{collaborator}', [CollaboratorsController::class, 'getNextPrevious']);
        Route::middleware('permission:Collaboration,read')->get('columns', [CollaboratorsController::class, 'getColumns']);
        Route::middleware('permission:Collaboration,read')->post('search', [CollaboratorsController::class, 'search']);
        Route::middleware('permission:Collaboration,read')->get('types', [CollaborationController::class, 'collaboratorTypes']);
        Route::middleware('permission:Collaboration,read')->get('type', [CollaboratorsController::class, 'getCollaboratorType']);
        Route::middleware('permission:Collaboration,read')->post('type', [CollaboratorsController::class, 'saveCollaboratorType']);
        Route::middleware('permission:Collaboration,read')->delete('type/{collaboratorType}', [CollaboratorsController::class, 'deleteCollaboratorType']);
    });
    Route::middleware('permission:Collaboration,resource')->resource('collaborator', CollaboratorsController::class);

    /**
     * Work-Order Collaborator Routes
     */
    Route::prefix('work-order')->group(function () {
        Route::prefix('collaborator')->group(function () {
            Route::middleware('permission:Collaboration,read')->get('paginateRecord', [WorkOrderCollaboratorsController::class, 'paginationRecord']);
            Route::middleware('permission:Collaboration,read')->get('getDropDownRecord', [WorkOrderCollaboratorsController::class, 'dropDownInfo']);
            Route::middleware('permission:Collaboration,read')->get('next/{collaborator}', [WorkOrderCollaboratorsController::class, 'getNextPrevious']);
            Route::middleware('permission:Collaboration,read')->get('previous/{collaborator}', [WorkOrderCollaboratorsController::class, 'getNextPrevious']);
            Route::middleware('permission:Collaboration,read')->get('columns', [WorkOrderCollaboratorsController::class, 'getColumns']);
            Route::middleware('permission:Collaboration,read')->post('search', [WorkOrderCollaboratorsController::class, 'search']);
            Route::middleware('permission:Collaboration,read')->get('types', [CollaborationController::class, 'collaboratorTypes']);
            Route::middleware('permission:Collaboration,read')->get('type', [WorkOrderCollaboratorsController::class, 'getCollaboratorType']);
            Route::middleware('permission:Collaboration,read')->post('type', [WorkOrderCollaboratorsController::class, 'saveCollaboratorType']);
            Route::middleware('permission:Collaboration,read')->delete('type/{collaboratorType}', [WorkOrderCollaboratorsController::class, 'deleteCollaboratorType']);
        });
        Route::middleware('permission:Collaboration,resource')->resource('collaborator', WorkOrderCollaboratorsController::class);
    });



    /**
     * Collaborator Type Routes
     */
    Route::prefix('collaboratorType')->group(function () {
        Route::middleware('permission:Collaboration,read')->get('columns', [CollaboratorTypeController::class, 'getColumns']);
        Route::middleware('permission:Collaboration,read')->post('search', [CollaboratorTypeController::class, 'search']);
    });
    Route::middleware('permission:Collaboration,resource')->resource('collaboratorType', CollaboratorTypeController::class);
    /**
     * Correspondence Routes
     * */
    Route::prefix('correspondence')->group(function () {
        Route::get('columns', [CorrespondenceController::class, 'getColumns']);
        Route::post('search', [CorrespondenceController::class, 'search']);
        Route::post('deleteTask/{task}', [CorrespondenceController::class, 'deleteTask']);
    });
    Route::resource('correspondence', CorrespondenceController::class);

    /**
     * Company Routes
     * */
    Route::group([
        'middleware' => 'permission:User,read',
        'prefix' => 'company'
    ], function () {
        Route::get('paginateRecord', [CompanyController::class, 'getPaginationRecord']);
        Route::get('getDropDownRecord', [CompanyController::class, 'getDropDownInfo']);
        Route::get('next/{company}', [CompanyController::class, 'getNext']);
        Route::get('previous/{company}', [CompanyController::class, 'getPrevious']);
        Route::get('first', [CompanyController::class, 'getFirst']);
        Route::get('last', [CompanyController::class, 'getLast']);
        Route::get('info', [CompanyController::class, 'companyInfo']);
        Route::get('columns', [CompanyController::class, 'getColumns']);
        Route::post('search', [CompanyController::class, 'search']);
        Route::get('type', [CompanyController::class, 'getCompanyInfoType']);
        Route::post('type', [CompanyController::class, 'saveCompanyInfoType']);
        Route::delete('type/{companyInfoType}', [CompanyController::class, 'deleteCompanyInfoType']);
    });
    Route::middleware('permission:User,resource')->resource('company', CompanyController::class);

    /**
     * Country Routes
     * */
    Route::group(['prefix' => 'country'], function () {
        Route::get('columns', [CountryController::class, 'getColumns']);
        Route::post('search', [CountryController::class, 'search']);
    });
    Route::resource('country', CountryController::class);

    /**
     *  Department Routes
     * */
    Route::group([
        'prefix' => 'department'
    ], function () {
        Route::get('paginateRecord', [DepartmentController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [DepartmentController::class, 'dropDownInfo']);
        Route::get('next/{department}', [DepartmentController::class, 'getNext']);
        Route::get('previous/{department}', [DepartmentController::class, 'getPrevious']);
        Route::get('first', [DepartmentController::class, 'getFirst']);
        Route::get('last', [DepartmentController::class, 'getLast']);
        Route::get('/info', [DepartmentController::class, 'departmentInfo']);
        Route::middleware('permission:Setting,read')->get('columns', [DepartmentController::class, 'getColumns']);
        Route::middleware('permission:Setting,read')->post('search', [DepartmentController::class, 'search']);
    });
    Route::middleware('permission:Setting,resource')->resource('department', DepartmentController::class);

    /**
     *  Cost P/Sq. Ft. Routes
     * */
    Route::group([
        'prefix' => 'costPerSqureFeet',
        'middleware' => 'permission:Setting,read'
    ], function (){
        Route::get('columns', [CostPSqureFeetController::class, 'getColumns']);
        Route::get('getDropDownRecord', [CostPSqureFeetController::class, 'dropDownInfo']);
        Route::get('next/{feet}', [CostPSqureFeetController::class, 'getNext']);
        Route::get('previous/{feet}', [CostPSqureFeetController::class, 'getPrevious']);
        Route::get('first', [CostPSqureFeetController::class, 'getFirst']);
        Route::get('last', [CostPSqureFeetController::class, 'getLast']);
        Route::post('search', [CostPSqureFeetController::class, 'search']);
    });
    /**
     * @todo if route model binding is not working then you need to add parameters to work it properly.
     *
     * When you use the parameters method with Route::resource, it allows you to customize the route parameter binding. In this case,
     * you specified 'costPerSqureFeet' as the parameter name for both the singular and plural versions.
     */
    Route::middleware('permission:Setting,resource')->resource('costPerSqureFeet', CostPSqureFeetController::class)->parameters([
        'costPerSqureFeet' => 'costPerSqureFeet'
    ]);

    /**
     * Order Status Routes
     */
    Route::group([
        'middleware' => 'permission:Setting,read',
        'prefix' => 'orderStatus'
    ], function () {
        Route::get('paginateRecord', [OrderStatusController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [OrderStatusController::class, 'dropDownInfo']);
        Route::get('next/{status}', [OrderStatusController::class, 'getNext']);
        Route::get('previous/{status}', [OrderStatusController::class, 'getPrevious']);
        Route::get('first', [OrderStatusController::class, 'getFirst']);
        Route::get('last', [OrderStatusController::class, 'getLast']);
        Route::get('columns', [OrderStatusController::class, 'getColumn']);
        Route::post('search', [OrderStatusController::class, 'search']);
    });
    Route::middleware('permission:Setting,resource')->resource('orderStatus', OrderStatusController::class);

    /**
     * Paper Location Route
     */
    Route::group([
        'prefix' => 'paperLocation'
    ], function () {
        Route::middleware('permission:Setting,read')->get('paginateRecord', [PaperLocationController::class, 'paginationRecord']);
        Route::middleware('permission:Setting,read')->get('getDropDownRecord', [PaperLocationController::class, 'dropDownInfo']);
        Route::middleware('permission:Setting,read')->get('next/{location}', [PaperLocationController::class, 'getNext']);
        Route::middleware('permission:Setting,read')->get('previous/{location}', [PaperLocationController::class, 'getPrevious']);
        Route::middleware('permission:Setting,read')->get('first', [PaperLocationController::class, 'getFirst']);
        Route::middleware('permission:Setting,read')->get('last', [PaperLocationController::class, 'getLast']);
        Route::get("/info", [PaperLocationController::class, 'paperLocationInfo']);
        Route::middleware('permission:Setting,read')->get("columns", [PaperLocationController::class, 'getColumns']);
        Route::middleware('permission:Setting,read')->post('search', [PaperLocationController::class, 'search']);
    });
    Route::middleware('permission:Setting,resource')->resource("paperLocation", PaperLocationController::class);

    /**
     *  Delivery work order Routes
     * */
    Route::prefix('deliveryWorkOrder')->group(function () {
        Route::get('/info', [DeliveryWorkOrderController::class, 'deliveryStoreLocationInfo']);
    });

    /**
     * Download Routes
     */
    Route::post('download', [DownloadFileController::class, 'index']);

    /**
     * Installation Routes
     * */
    Route::prefix('installation')->group(function () {
        Route::middleware('permission:Installation,read')->get('paginateRecord', [InstallationController::class, 'getRecordPagination']);
        Route::middleware('permission:Installation,read')->get('getDropDownRecord', [InstallationController::class, 'getDropDownRecord']);
        Route::middleware('permission:Installation,read')->get('next/{installation}', [InstallationController::class, 'next']);
        Route::middleware('permission:Installation,read')->get('previous/{installation}', [InstallationController::class, 'previous']);
        Route::middleware('permission:Installation,read')->get('first', [InstallationController::class, 'first']);
        Route::middleware('permission:Installation,read')->get('last', [InstallationController::class, 'last']);
        Route::middleware('permission:Installation,read')->get('columns', [InstallationController::class, 'getColumns']);
        Route::middleware('permission:Installation,read')->post('search', [InstallationController::class, 'search']);
        Route::middleware('permission:Installation,read')->get('check-list/{installation}', [InstallationController::class, 'getCheckList']);
        Route::middleware('permission:Installation,create')->post('check-list', [InstallationController::class, 'saveCheckList']);
        Route::middleware('permission:Installation,delete')->delete('check-list/{installation}', [InstallationController::class, 'deleteCheckList']);
        Route::middleware('permission:Installation,read')->get('vase-direction', [InstallationController::class, 'getVaseDirection']);
        Route::middleware('permission:Installation,read')->get('foundation-depth', [InstallationController::class, 'getFoundationDepth']);
        Route::middleware('permission:Installation,read')->post('vase-direction', [InstallationController::class, 'saveVaseDirection']);
        Route::middleware('permission:Installation,read')->post('foundation-depth', [InstallationController::class, 'saveFoundationDepth']);
        Route::middleware('permission:Installation,update')->post('saveCustomText', [InstallationController::class, 'saveInstallCustomText']);
        Route::middleware('permission:Installation,read')->delete('vase-direction/{vaseDirection}', [InstallationController::class, 'deleteVaseDirection']);
        Route::middleware('permission:Installation,read')->delete('foundation-depth/{foundationDepth}', [InstallationController::class, 'deleteFoundationDepth']);
    });
    Route::middleware('permission:Installation,resource')->resource('installation', InstallationController::class);

    /**
     * Weekly Schedule Routes
     * */
    Route::group([
        'middleware' => 'permission:Installation,read',
        'prefix' => 'weeklySchedule'
    ], function () {
        Route::get('paginateRecord', [WeeklyScheduleController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [WeeklyScheduleController::class, 'dropDownInfo']);
        Route::get('next/{schedule}', [WeeklyScheduleController::class, 'getNext']);
        Route::get('previous/{schedule}', [WeeklyScheduleController::class, 'getPrevious']);
        Route::get('first', [WeeklyScheduleController::class, 'getFirst']);
        Route::get('last', [WeeklyScheduleController::class, 'getLast']);
        Route::get('columns', [WeeklyScheduleController::class, 'getColumns']);
        Route::post('search', [WeeklyScheduleController::class, 'search']);
        Route::get('order', [WeeklyScheduleController::class, 'weeklyScheduleOrder']);
    });
    Route::middleware('permission:Installation,resource')->resource('weeklySchedule', WeeklyScheduleController::class);

    /**
     * Installation Daily Load Check List Routes
     * */
    Route::group([
        'middleware' => 'permission:Installation,read',
        'prefix' => 'installer'
    ], function () {
        Route::get('paginateRecord', [InstallerController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [InstallerController::class, 'dropDownInfo']);
        Route::get('next/{installer}', [InstallerController::class, 'getNext']);
        Route::get('previous/{installer}', [InstallerController::class, 'getPrevious']);
        Route::get('first', [InstallerController::class, 'getFirst']);
        Route::get('last', [InstallerController::class, 'getLast']);
        Route::get('columns', [InstallerController::class, 'getColumns']);
        Route::post('search', [InstallerController::class, 'search']);
        Route::get('order', [InstallerController::class, 'installerOrder']);
    });
    Route::middleware('permission:Installation,resource')->resource('installer', InstallerController::class);

    /**
     * Installation Production Routes
     * */
    Route::group([
        'middleware' => 'permission:Installation,read',
        'prefix' => 'installationProduction'
    ], function () {
        Route::get('paginateRecord', [InstallationProductionController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [InstallationProductionController::class, 'dropDownInfo']);
        Route::get('next/{production}', [InstallationProductionController::class, 'getNext']);
        Route::get('previous/{production}', [InstallationProductionController::class, 'getPrevious']);
        Route::get('first', [InstallationProductionController::class, 'getFirst']);
        Route::get('last', [InstallationProductionController::class, 'getLast']);
        Route::get('columns', [InstallationProductionController::class, 'getColumns']);
        Route::post('search', [InstallationProductionController::class, 'search']);
        Route::get('order', [InstallationProductionController::class, 'installerProductionOrder']);
    });
    Route::middleware('permission:Installation,resource')->resource('installationProduction', InstallationProductionController::class);

    /**
     * Truck Load List Routes
     * */
    Route::group([
        'middleware' => 'permission:Installation,read',
        'prefix' => 'loader'
    ], function () {
        Route::get('paginateRecord', [LoaderController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [LoaderController::class, 'dropDownInfo']);
        Route::get('next/{loader}', [LoaderController::class, 'getNext']);
        Route::get('previous/{loader}', [LoaderController::class, 'getPrevious']);
        Route::get('first', [LoaderController::class, 'getFirst']);
        Route::get('last', [LoaderController::class, 'getLast']);
        Route::get('columns', [LoaderController::class, 'getColumns']);
        Route::post('search', [LoaderController::class, 'search']);
        Route::get('getInstall/{installation}', [LoaderController::class, 'getInstallation']);
        Route::get('getLoader/{installation}', [LoaderController::class, 'getLoader']);
        Route::get('order', [LoaderController::class, 'loaderOrder']);
    });
    Route::middleware('permission:Installation,resource')->resource('loader', LoaderController::class);

    /**
     *  Monument Routes
     * */
    Route::prefix('monument')->group(function () {
        Route::middleware('permission:Products,read')->get('next/{monument}', [MonumentController::class, 'getNextPrevious']);
        Route::middleware('permission:Products,read')->get('previous/{monument}', [MonumentController::class, 'getNextPrevious']);
        Route::middleware('permission:Products,read')->get('dropDown', [MonumentController::class, 'getDropDown']);
        Route::middleware('permission:Products,read')->get('/info', [MonumentController::class, 'monumentInfo']);
        Route::middleware('permission:Products,read')->get('paginateRecord', [MonumentController::class, 'getRecordPagination']);
        Route::middleware('permission:Products,read')->get('columns', [MonumentController::class, 'getColumns']);
        Route::middleware('permission:Products,read')->post('search', [MonumentController::class, 'search']);
        Route::middleware('permission:Products,read')->post('toggleComponent', [MonumentController::class, 'toggleComponent']);
        Route::middleware('permission:Products,delete')->post('deleteFile/{document}', [MonumentController::class, 'deleteFile']);
        Route::middleware('permission:Products,delete')->post('deleteImage/{document}', [MonumentController::class, 'deleteImage']);
    });
    Route::middleware('permission:Products,resource')->resource('monument', MonumentController::class);

    /**
     *  Monument Type Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'monumentType'
    ], function () {
        Route::get('columns', [MonumentTypeController::class, 'getColumns']);
        Route::post('search', [MonumentTypeController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('monumentType', MonumentTypeController::class);

    /**
     *  Monument Side Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'monumentSide'
    ], function () {
        Route::get('columns', [MonumentSideController::class, 'getColumns']);
        Route::post('search', [MonumentSideController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('monumentSide', MonumentSideController::class);

    /**
     * Monument Polish Routes
     */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'monumentPolish'
    ], function () {
        Route::get('columns', [MonumentPolishController::class, 'getColumns']);
        Route::post('search', [MonumentPolishController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('monumentPolish', MonumentPolishController::class);

    /**
     *  Monument Color Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'monumentColor'
    ], function () {
        Route::get('columns', [MonumentColorController::class, 'getColumns']);
        Route::post('search', [MonumentColorController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('monumentColor', MonumentColorController::class);

    /**
     *  Monument Shape Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'monumentShape'
    ], function () {
        Route::get('columns', [MonumentShapeController::class, 'getColumns']);
        Route::post('search', [MonumentShapeController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('monumentShape', MonumentShapeController::class);

    /**
     * Order Routes
     * */
    Route::prefix('order')->group(function () {
        Route::middleware('permission:Orders,read')->get('paginateRecord', [OrderController::class, 'getRecordPagination']);
        Route::middleware('permission:Orders,read')->get('getDropDownRecord', [OrderController::class, 'getDropDownRecord']);
        Route::middleware('permission:Orders,read')->get('next/{order}', [OrderController::class, 'getNext']);
        Route::middleware('permission:Orders,read')->get('previous/{order}', [OrderController::class, 'getPrevious']);
        Route::middleware('permission:Orders,read')->get('first', [OrderController::class, 'getFirst']);
        Route::middleware('permission:Orders,read')->get('last', [OrderController::class, 'getLast']);
        Route::middleware('permission:Orders,read')->get('orderType', [OrderController::class, 'orderType']);
        Route::middleware('permission:Orders,create')->post('orderType', [OrderController::class, 'saveOrderType']);
        Route::middleware('permission:Orders,delete')->delete('orderType/{orderType}', [OrderController::class, 'deleteOrderType']);
        Route::middleware('permission:Orders,read')->get('totalRecord', [OrderController::class, 'getTotalRecord']);
        Route::middleware('permission:Orders,read')->get('columns', [orderController::class, 'getColumns']);
        Route::middleware('permission:Orders,read')->post('search', [orderController::class, 'search']);
        Route::middleware('permission:Orders,read')->post('searchProducts', [orderController::class, 'searchProducts']);
        Route::middleware('permission:Orders,delete')->post('deleteProduct/{product}', [orderController::class, 'deleteProduct']);
        Route::middleware('permission:Orders,delete')->post('deleteMemorialProductionProduct/{product}', [orderController::class, 'deleteMemorialProductionProduct']);
        Route::middleware('permission:Orders,read')->post('searchUsers', [orderController::class, 'searchUsers']);
        Route::middleware('permission:Orders,create')->post('addPayment', [orderController::class, 'addPayment']);
        Route::middleware('permission:Orders,read')->get('form/{order}', [orderController::class, 'getOrderForm']);
        Route::middleware('permission:Orders,create')->post('form', [orderController::class, 'saveOrderForm']);
        Route::middleware('permission:Orders,read')->get('brick/{order}', [orderController::class, 'getBrick']);
        Route::middleware('permission:Orders,create')->post('brick', [orderController::class, 'saveBrick']);
        Route::middleware('permission:Orders,read')->get('granit_bronz_memorial/{order}', [orderController::class, 'getGranitBronzMemorial']);
        Route::middleware('permission:Orders,create')->post('granit_bronz_memorial', [orderController::class, 'saveGranitBronzMemorial']);
        Route::middleware('permission:Orders,read')->get('granit_bronz_precious/{order}', [orderController::class, 'getGranitBronzPrecious']);
        Route::middleware('permission:Orders,create')->post('granit_bronz_precious', [orderController::class, 'saveGranitBronzPrecious']);
        Route::middleware('permission:Orders,read')->get('monumentAgreement/{order}', [orderController::class, 'getMonumentAgreement']);
        Route::middleware('permission:Orders,create')->post('monumentAgreement', [orderController::class, 'saveMonumentAgreement']);
        Route::middleware('permission:Orders,read')->get('monumentWorkOrder/{order}', [orderController::class, 'getMonumentWorkOrder']);
        Route::middleware('permission:Orders,create')->post('monumentWorkOrder', [orderController::class, 'saveMonumentWorkOrder']);
        Route::middleware('permission:Orders,read')->get('finalDate/{order}', [orderController::class, 'getFinalDate']);
        Route::middleware('permission:Orders,create')->post('finalDate', [orderController::class, 'saveFinalDate']);
        Route::middleware('permission:Orders,read')->get('porcelain/{order}', [orderController::class, 'getPorcelain']);
        Route::middleware('permission:Orders,create')->post('porcelain', [orderController::class, 'savePorcelain']);
        Route::middleware('permission:Orders,read')->get('monumentOrderNotes/{order}', [orderController::class, 'getMonumentOrderNotes']);
        Route::middleware('permission:Orders,create')->post('monumentOrderNotes', [orderController::class, 'saveMonumentOrderNotes']);
        Route::middleware('permission:Orders,read')->get('deliveryWorkOrder/{order}', [orderController::class, 'getDeliveryWorkOrder']);
        Route::middleware('permission:Orders,create')->post('deliveryWorkOrder', [orderController::class, 'saveDeliveryWorkOrder']);
        Route::middleware('permission:Orders,read')->get('memorialProduction/{order}', [orderController::class, 'getMemorialProduction']);
        Route::middleware('permission:Orders,create')->post('memorialProduction', [orderController::class, 'saveMemorialProduction']);
        Route::middleware('permission:Orders,read')->get('approvalMonument/{order}', [orderController::class, 'getApprovalMonument']);
        Route::middleware('permission:Orders,create')->post('approvalMonument', [orderController::class, 'saveApprovalMonument']);
        Route::middleware('permission:Orders,create')->post('syncOrdersApi', [orderController::class, 'syncOrdersApi']);
        Route::middleware('permission:Orders,create')->post('uploadOrderImage', [orderController::class, 'uploadOrderImage']);

    });
    Route::middleware('permission:Orders,resource')->resource('order', OrderController::class);

    /**
     * Customer Portal invoice Routes
     */
    Route::group([
        'middleware' => 'permission:Customer Portal,read',
        'prefix' => 'customerPortal'
    ], function () {
        Route::get('orderColumns', [orderController::class, 'getColumns']);
        Route::get('customerOrder', [orderController::class, 'customerOrder']);
        Route::post('search', [orderController::class, 'searchCustomerOrder']);
        Route::get('showOrder/{order}', [orderController::class, 'showCustomerOrder']);
        Route::get('companyInfo', [CompanyController::class, 'index']);
        Route::get('cemeteryInfo', [CemeteryController::class, 'index']);

    });

    /**
     * customer portal order status routes
     */
    Route::group([
        'middleware' => 'permission:Customer Portal,read',
        'prefix' => 'customerOrderStatus'
    ], function () {
        Route::get('productionColumn', [ProductionController::class, 'getColumns']);
        Route::get('orderStatusInfo', [ProductionController::class, 'customerOrderStatus']);
        Route::post('search', [ProductionController::class, 'searchCustomerOrderStatus']);
        Route::get('production/{production}', [ProductionController::class, 'show']);

    });

    /**
     * customer portal approval routes
     */
    Route::group([
        'middleware' => 'permission:Customer Portal,read',
        'prefix' => 'customerApproval'
    ], function () {
        Route::get('approvalColumn', [CollaborationController::class, 'getColumns']);
        Route::get('approvalInfo', [CollaborationController::class, 'customerApproval']);
        Route::post('search', [CollaborationController::class, 'searchCustomerApproval']);
        Route::get('approval/{collaboration}', [CollaborationController::class, 'show']);

    });

    /**
     * customer portal collaboration routes
     */
    Route::group([
        'middleware' => 'permission:Customer Portal,read',
        'prefix' => 'customerCollaboration'
    ], function () {
        Route::get('collaborationColumn', [CollaborationController::class, 'getColumns']);
        Route::get('collaborationInfo', [CollaborationController::class, 'customerApproval']);
        Route::post('search', [CollaborationController::class, 'searchCustomerApproval']);
        Route::get('collaboration/{collaboration}', [CollaborationController::class, 'show']);
    });

    /**
     * Order Installation Routes
     * */
    Route::group([
        'middleware' => 'permission:Orders,read',
        'prefix' => 'orderInstallation'
    ], function () {
        Route::get('columns', [OrderInstallationController::class, 'getColumns']);
        Route::post('search', [OrderInstallationController::class, 'search']);
    });
    Route::middleware('permission:Orders,resource')->resource('orderInstallation', OrderInstallationController::class);

    /**
     *  Porcelain Routes
     * */
    Route::prefix('porcelain')->group(function () {
        Route::get('/info', [PorcelainController::class, 'porcelainInfo']);
    });

    /**
     * Report Routes
     */

    Route::prefix('report')->group(function () {
        Route::get('info', [MonumentController::class, 'reportInfo']);
        Route::get('reorderColumns', [MonumentController::class, 'getColumns']);
        Route::post('searchMonument', [MonumentController::class, 'monumentSearch']);
        Route::post('searchService', [ServiceController::class, 'serviceSearch']);
        Route::post('searchSimple', [SimpleController::class, 'simpleSearch']);
    });

    /**
     * Product Catalog Routes
     */

    Route::prefix('productCatalog')->group(function () {
        Route::get('info', [ProductCatalogController::class, 'index']);
        Route::get('catalogColumns', [ProductCatalogController::class, 'getColumns']);
        Route::post('searchMonument', [ProductCatalogController::class, 'monumentSearch']);
        Route::post('searchService', [ProductCatalogController::class, 'serviceSearch']);
        Route::post('searchSimple', [ProductCatalogController::class, 'simpleSearch']);
        Route::post('searchComposite', [ProductCatalogController::class, 'compositeSearch']);
    });

    /**
     * Task Collaboration Routes
     */

    Route::prefix('collaborationTask')->group(function () {
        Route::get('info', [TaskCollaborationReportController::class, 'index']);
        Route::get('allRecords', [TaskCollaborationReportController::class, 'printAllRecord']);
        Route::get('taskColumns', [TaskCollaborationReportController::class, 'getColumns']);
        Route::post('search', [TaskCollaborationReportController::class, 'search']);
    });

    Route::prefix('correspondenceTask')->group(function () {
        Route::get('info', [TaskCollaborationReportController::class, 'correspondanceTask']);
        Route::get('allRecords', [TaskCollaborationReportController::class, 'printCorrespondenceRecord']);
        Route::get('taskColumns', [TaskCollaborationReportController::class, 'taskColumns']);
        Route::post('search', [TaskCollaborationReportController::class, 'taskSearch']);
    });

    /**
     * Report Composite Routes
     */
    Route::prefix('compositeReport')->group(function () {
        Route::get('columns', [CompositeController::class, 'getColumns']);
        Route::get('info', [CompositeController::class, 'compositeReportInfo']);
        Route::post('search', [CompositeController::class, 'compositeSearch']);
    });

    /**
     * Sale Report Routes
     */
    Route::prefix('saleReport')->group(function () {
        Route::get('columns', [OrderController::class, 'getReportColumn']);
        Route::get('info', [OrderController::class, 'index']);
        Route::post('search', [OrderController::class, 'orderSearch']);
    });


    /**
     * Production Routes
     * */
    Route::group([
        'middleware' => 'permission:Production,read',
        'prefix' => 'production'
    ], function () {
        Route::get('getDropDownRecord', [ProductionController::class, 'getDropDownRecord']);
        Route::get('next/{production}', [ProductionController::class, 'getNext']);
        Route::get('previous/{production}', [ProductionController::class, 'getPrevious']);
        Route::get('first', [ProductionController::class, 'getFirst']);
        Route::get('last', [ProductionController::class, 'getLast']);
        Route::get('paginateRecord', [ProductionController::class, 'getRecordPagination']);
        Route::get('columns', [ProductionController::class, 'getColumns']);
        Route::post('search', [ProductionController::class, 'search']);
        Route::middleware('permission:Production,update')->post('saveCustomText', [ProductionController::class, 'saveCustomText']);
        Route::middleware('permission:Production,update')->post('saveInstallCustomText', [InstallationController::class, 'saveInstallCustomText']);
    });
    Route::middleware('permission:Production,resource')->resource('production', ProductionController::class);

    /**
     * Production OC Picture Routes
     * */
    Route::group([
        'middleware' => 'permission:Production,read',
        'prefix' => 'productionPicture'
    ], function () {
        Route::get('paginateRecord', [ProductionOcPictureController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [ProductionOcPictureController::class, 'dropDownInfo']);
        Route::get('next/{ocPicture}', [ProductionOcPictureController::class, 'getNext']);
        Route::get('previous/{ocPicture}', [ProductionOcPictureController::class, 'getPrevious']);
        Route::get('first', [ProductionOcPictureController::class, 'getFirst']);
        Route::get('last', [ProductionOcPictureController::class, 'getLast']);
        Route::get('columns', [ProductionOcPictureController::class, 'getColumns']);
        Route::post('search', [ProductionOcPictureController::class, 'search']);
        Route::get('order', [ProductionOcPictureController::class, 'pictureOrder']);
    });
    Route::middleware('permission:Production,resource')->resource('productionPicture', ProductionOcPictureController::class);

    /**
     * Production Sandblasting Routes
     * */
    Route::group([
        'middleware' => 'permission:Production,read',
        'prefix' => 'productionSandblasting'
    ], function () {
        Route::get('paginateRecord', [ProductionSandblastingController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [ProductionSandblastingController::class, 'dropDownInfo']);
        Route::get('next/{sandblast}', [ProductionSandblastingController::class, 'getNext']);
        Route::get('previous/{sandblast}', [ProductionSandblastingController::class, 'getPrevious']);
        Route::get('first', [ProductionSandblastingController::class, 'getFirst']);
        Route::get('last', [ProductionSandblastingController::class, 'getLast']);
        Route::get('columns', [ProductionSandblastingController::class, 'getColumns']);
        Route::post('search', [ProductionSandblastingController::class, 'search']);
        Route::get('order', [ProductionSandblastingController::class, 'sandBlastingOrder']);
    });
    Route::middleware('permission:Production,resource')->resource('productionSandblasting', ProductionSandblastingController::class);

    /**
     * Production Laser Routes
     * */
    Route::group([
        'middleware' => 'permission:Production,read',
        'prefix' => 'productionLaser'
    ], function () {
        Route::get('paginateRecord', [ProductionLaserController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [ProductionLaserController::class, 'dropDownInfo']);
        Route::get('next/{laser}', [ProductionLaserController::class, 'getNext']);
        Route::get('previous/{laser}', [ProductionLaserController::class, 'getPrevious']);
        Route::get('first', [ProductionLaserController::class, 'getFirst']);
        Route::get('last', [ProductionLaserController::class, 'getLast']);
        Route::get('columns', [ProductionLaserController::class, 'getColumns']);
        Route::post('search', [ProductionLaserController::class, 'search']);
        Route::get('order', [ProductionLaserController::class, 'laserOrder']);
    });
    Route::middleware('permission:Production,resource')->resource('productionLaser', ProductionLaserController::class);

    /**
     * Quote Routes
     * */
    Route::prefix('quote')->group(function () {
        Route::middleware('permission:Quotes,read')->get('paginateRecord', [QuoteController::class, 'getRecordPagination']);
        Route::middleware('permission:Quotes,read')->get('getDropDownRecord', [QuoteController::class, 'getDropDownRecord']);
        Route::middleware('permission:Quotes,read')->get('next/{quote}', [QuoteController::class, 'getNext']);
        Route::middleware('permission:Quotes,read')->get('previous/{quote}', [QuoteController::class, 'getPrevious']);
        Route::middleware('permission:Quotes,read')->get('first', [QuoteController::class, 'getFirst']);
        Route::middleware('permission:Quotes,read')->get('last', [QuoteController::class, 'getLast']);
        Route::middleware('permission:Quotes,read')->get('columns', [QuoteController::class, 'getColumns']);
        Route::middleware('permission:Quotes,read')->post('search', [QuoteController::class, 'search']);
        Route::middleware('permission:Quotes,read')->post('searchProducts', [QuoteController::class, 'searchProducts']);
        Route::middleware('permission:Quotes,delete')->post('deleteProduct/{product}', [QuoteController::class, 'deleteProduct']);
    });
    Route::middleware('permission:Quotes,resource')->resource('quote', QuoteController::class);

    /**
     * Simple Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'simple'
    ], function () {
        Route::get('/info', [SimpleController::class, 'simpleInfo']);
        Route::get('columns', [SimpleController::class, 'getColumns']);
        Route::post('search', [SimpleController::class, 'search']);
        Route::get('dropDown', [SimpleController::class, 'getDropDown']);
        Route::get('next/{simple}', [SimpleController::class, 'getNextPrevious']);
        Route::middleware('permission:Products,read')->get('paginateRecord', [SimpleController::class, 'getRecordPagination']);
    });
    Route::middleware('permission:Products,resource')->resource('simple', SimpleController::class);
    Route::prefix('simple')->group(function () {
        Route::middleware('permission:Products,delete')->post('deleteFile/{document}', [SimpleController::class, 'deleteFile']);
        Route::middleware('permission:Products,delete')->post('deleteImage/{document}', [SimpleController::class, 'deleteImage']);
    });
    /**
     *  Simple Category Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'simpleCategory'
    ], function () {
        Route::get('columns', [SimpleCategoryController::class, 'getColumns']);
        Route::post('search', [SimpleCategoryController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('simpleCategory', SimpleCategoryController::class);


    /**
     * Service Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'service'
    ], function () {
        Route::get('/info', [ServiceController::class, 'serviceInfo']);
        Route::get('columns', [ServiceController::class, 'getColumns']);
        Route::get('dropDown', [ServiceController::class, 'getDropDown']);
        Route::get('next/{service}', [ServiceController::class, 'getNextPrevious']);
        Route::middleware('permission:Products,read')->get('paginateRecord', [ServiceController::class, 'getRecordPagination']);
        Route::post('search', [ServiceController::class, 'search']);
    });
    Route::prefix('service')->group(function () {
        Route::middleware('permission:Products,delete')->post('deleteFile/{document}', [ServiceController::class, 'deleteFile']);
        Route::middleware('permission:Products,delete')->post('deleteImage/{document}', [ServiceController::class, 'deleteImage']);
    });
    Route::middleware('permission:Products,resource')->resource('service', ServiceController::class);

    /**
     *  Service Category Routes
     * */
    Route::group([
        'middleware' => 'permission:Products,read',
        'prefix' => 'serviceCategory'
    ], function () {
        Route::get('columns', [ServiceCategoryController::class, 'getColumns']);
        Route::post('search', [ServiceCategoryController::class, 'search']);
    });
    Route::middleware('permission:Products,resource')->resource('serviceCategory', ServiceCategoryController::class);


    /**
     *  User Role Routes
     * */
    Route::prefix('userRole')->group(function () {
        Route::get('columns', [userRolesController::class, 'getColumns']);
        Route::post('search', [userRolesController::class, 'search']);
    });
    Route::resource('userRole', userRolesController::class);

    /**
     *  User Routes
     * */

    Route::prefix('user')->group(function () {
        Route::get('paginateRecord', [UserController::class, 'getPaginationRecord']);
        Route::get('getDropDownRecord', [UserController::class, 'getDropDownInfo']);
        Route::get('next/{user}', [UserController::class, 'getNextPrevious']);
        Route::get('previous/{user}', [UserController::class, 'getNextPrevious']);
        Route::get('columns', [UserController::class, 'getColumns']);
        Route::post('search', [UserController::class, 'search']);
        Route::get('info', [UserController::class, 'userInfo']);
        Route::get('families', [UserController::class, 'userFamiliesInfo']);
    });
    Route::resource('user', UserController::class);

    /**
     *  User Resource Routes
     * */
    Route::group([
        'middleware' => 'permission:Setting,read',
        'prefix' => 'userResources'
    ], function () {
        Route::get('columns', [UserRoutesLinkController::class, 'getColumns']);
        Route::post('search', [UserRoutesLinkController::class, 'search']);
        Route::get('info', [UserRoutesLinkController::class, 'resourcesInfo']);
    });
    Route::middleware('permission:Setting,resource')->resource('userResources', UserRoutesLinkController::class);

    /**
     *  Maintenance Work Order Routes
     * */

    Route::group([
        'middleware' => 'permission:Maintenance,read',
        'prefix' => 'maintenanceWorkOrder'
    ], function () {
        Route::get('paginateRecord', [MaintenanceWorkOrderController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [MaintenanceWorkOrderController::class, 'dropDownInfo']);
        Route::get('next/{workOrder}', [MaintenanceWorkOrderController::class, 'getNext']);
        Route::get('previous/{workOrder}', [MaintenanceWorkOrderController::class, 'getPrevious']);
        Route::get('first', [MaintenanceWorkOrderController::class, 'getFirst']);
        Route::get('last', [MaintenanceWorkOrderController::class, 'getLast']);
        Route::get('columns', [MaintenanceWorkOrderController::class, 'getColumns']);
        Route::post('search', [MaintenanceWorkOrderController::class, 'search']);
        Route::get('info', [MaintenanceWorkOrderController::class, 'maintenanceWorkOrderInfo']);


        /* ------------------ */
        Route::post('mail', [MaintenanceWorkOrderController::class, 'sendMail']);
        Route::post('uploadImage', [MaintenanceWorkOrderController::class, 'uploadImage']);

        Route::middleware('permission:Collaboration,delete')->post('deleteFile/{id}', [MaintenanceWorkOrderController::class, 'deleteFile']);

        Route::middleware('permission:Collaboration,create')->post('updateImages', [MaintenanceWorkOrderController::class, 'updateImage']);
        Route::post('sendApprovalMail', [MaintenanceWorkOrderController::class, 'sendApprovalMail']);

        Route::post('sendCustomerViewMail', [MaintenanceWorkOrderController::class, 'sendCustomerViewMail']);
    });
    Route::middleware('permission:Maintenance,resource')->resource('maintenanceWorkOrder', MaintenanceWorkOrderController::class);

    /**
     * Supplier Routes
     * */
    Route::group([
        'middleware' => 'permission:Purchasing,read',
        'prefix' => 'supplier'
    ], function () {
        Route::get('paginateRecord', [SupplierController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [SupplierController::class, 'dropDownInfo']);
        Route::get('next/{supplier}', [SupplierController::class, 'getNext']);
        Route::get('previous/{supplier}', [SupplierController::class, 'getPrevious']);
        Route::get('first', [SupplierController::class, 'getFirst']);
        Route::get('last', [SupplierController::class, 'getLast']);
        Route::get('columns', [SupplierController::class, 'getColumns']);
        Route::post('search', [SupplierController::class, 'search']);
    });
    Route::middleware('permission:Purchasing,resource')->resource('supplier', SupplierController::class);

    /**
     * Equipment Routes
     * */
    Route::group([
        'middleware' => 'permission:Maintenance,read',
        'prefix' => 'equipment'
    ], function () {
        Route::get('paginateRecord', [EquipmentController::class, 'paginationRecord']);
        Route::get('getDropDownRecord', [EquipmentController::class, 'dropDownInfo']);
        Route::get('next/{equipment}', [EquipmentController::class, 'getNext']);
        Route::get('previous/{equipment}', [EquipmentController::class, 'getPrevious']);
        Route::get('first', [EquipmentController::class, 'getFirst']);
        Route::get('last', [EquipmentController::class, 'getLast']);
        Route::get('columns', [EquipmentController::class, 'getColumns']);
        Route::post('search', [EquipmentController::class, 'search']);
    });
    Route::middleware('permission:Maintenance,resource')->resource('equipment', EquipmentController::class);

    /**
     * Mobile routes
     */
    Route::group([
        'prefix' => 'mobile'
    ], function () {
        Route::prefix('collaboration')->group(function () {
            Route::get('index', [CollaborationController::class, 'index']);
            Route::post('uploadImage', [CollaborationController::class, 'mobileUploadImage']);
        });

        /**
         * ProductionOcPicture Routes
         */
        Route::prefix('productionPicture')->group(function () {
            Route::get('index', [ProductionOcPictureController::class, 'index']);
            Route::post('store', [ProductionOcPictureController::class, 'jwtStore']);
            Route::post('show/{id}', [ProductionOcPictureController::class, 'show']);
            Route::post('destroy/{id}', [ProductionOcPictureController::class, 'destroy']);
        });


        /**
         * ProductionSandblastingController Routes
         */
        Route::prefix('productionSandblasting')->group(function () {
            Route::get('index', [ProductionSandblastingController::class, 'index']);
            Route::post('store', [ProductionSandblastingController::class, 'jwtStore']);
            Route::post('show/{id}', [ProductionSandblastingController::class, 'show']);
            Route::post('destroy/{id}', [ProductionSandblastingController::class, 'destroy']);
        });

        /**
         * ProductionLaserController Routes
         */
        Route::prefix('productionLaser')->group(function () {
            Route::get('index', [ProductionLaserController::class, 'index']);
            Route::post('store', [ProductionLaserController::class, 'jwtStore']);
            Route::post('show/{id}', [ProductionLaserController::class, 'show']);
            Route::post('destroy/{id}', [ProductionLaserController::class, 'destroy']);
        });

        Route::get('invoiceOrders', [OrderController::class, 'invoiceOrders']);
    });

    /**
     *  Sync Order List Route
     * */
//    Route::post('syncOrders', [OrderController::class, 'syncOrders']);

});
