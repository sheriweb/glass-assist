<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupEmailController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SendLogController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleManagementController;
use App\Http\Controllers\WhatWindscreenApiController;
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
Route::get('api/{id}',[VehicleController::class,'getWhatWindScreenLookUpById']);
//todo just for testing

//Route::get('api',function (){
//    $curl = curl_init();
//
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => 'https://api.whatwindscreen.com/api/30',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => '',
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 0,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'GET',
//        CURLOPT_HTTPHEADER => array(
//            'ApiToken: mVnHyCaJFZoUQzi',
//            'ApiAccountCode: S900661'
//        ),
//    ));
//
//    $response = curl_exec($curl);
//    if ($response === false) {
//        // cURL error occurred
//        $error = curl_error($curl);
//        dd($error);
//    }
//    curl_close($curl);
//    dd($response);
//});

//Route::get('/create/api',function (){
//$curl = curl_init();
//
//curl_setopt_array($curl, array(
//    CURLOPT_URL => 'https://api.whatwindscreen.com/api/',
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => '',
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 0,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => 'POST',
//    CURLOPT_POSTFIELDS =>'{
//    "glassItem": 9,
//    "vehicleReg": "GL08VCG",
//    "vehicleVIN": "GL3345835SDSFSD353",
//    "vehicleMake": "Honda",
//    "vehicleModel": "Civic",
//    "vehicleYear": "2008"
//}',
//    CURLOPT_HTTPHEADER => array(
//        'ApiToken: mVnHyCaJFZoUQzi',
//        'ApiAccountCode: S900661'
//    ),
//));

//$response = curl_exec($curl);
//
//curl_close($curl);
// dd($response);
//
//});

// Auth
Route::group(
    ['middleware' => 'guest'],
    function () {
        Route::get('/login', [LoginController::class, 'index'])->name('user-login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

        Route::get('register', [RegisterController::class, 'index'])->name('user-register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.attempt');
    }
);

Route::post('/logout', [LoginController::class, 'logout'])->name('user-logout');
Route::get(
    '/terms',
    function () {
        return view('terms');
    }
)->name('terms');

Route::group(
    ['middleware' => ['auth']],
    function () {
        // Dashboard
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/company/detail/{id}', [CompanyController::class, 'detail'])->name('company.detail');

        // Customers
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
        Route::match(['get', 'post'], '/customer/new', [CustomerController::class, 'newCustomer'])
            ->name('customer.add-customer');
        Route::match(['get', 'put'], '/customer/edit/{id}', [CustomerController::class, 'editCustomer'])
            ->name('customer.edit-customer');

        Route::match(['get', 'put'], '/vehicle/add/{id}', [CustomerController::class, 'customerLinkVehicle'])
            ->name('customer.customer-link-vehicle');

        Route::get('/customer/companies', [CustomerController::class, 'companies'])->name('customer.companies');
        Route::match(['get', 'post'], '/customer/company/new', [CustomerController::class, 'newCompany'])
            ->name('customer.add-company');
        Route::match(['get', 'put'], '/customer/company/edit/{id}', [CustomerController::class, 'editCompany'])
            ->name('customer.edit-company');

        Route::get('/customer/glass-suppliers', [CustomerController::class, 'glassSuppliers'])
            ->name('customer.glass-suppliers');
        Route::match(['get', 'post'], '/customer/glass-suppliers/new', [CustomerController::class, 'newGlassSupplier'])
            ->name('customer.add-glass-suppliers');
        Route::match(
            ['get', 'put'],
            '/customer/glass-suppliers/edit/{id}',
            [CustomerController::class, 'editGlassSupplier']
        )
            ->name('customer.edit-glass-suppliers');

        Route::get('/customer/sub-contractors', [CustomerController::class, 'subContractors'])
            ->name('customer.sub-contractors');
        Route::match(['get', 'post'], '/customer/sub-contractors/new', [CustomerController::class, 'newSubContractor'])
            ->name('customer.add-sub-contractors');
        Route::match(
            ['get', 'put'],
            '/customer/sub-contractors/edit/{id}',
            [CustomerController::class, 'editSubContractor']
        )
            ->name('customer.edit-sub-contractors');

        Route::get('/customer/{customerId}/link-vehicle/{vehicleId}', [CustomerController::class, 'linkVehicle']);

        // Vehicles{
        Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle');
        Route::match(['get', 'post'], '/vehicle/new', [VehicleController::class, 'newVehicle'])->name('add-vehicle');
        Route::match(['get', 'put'], '/vehicle/edit/{id}', [VehicleController::class, 'editVehicle'])->name(
            'edit-vehicle'
        );

        Route::post('/vehicle/dvla-lookup', [VehicleController::class, 'dvlaLookup'])->name('vehicle.dvla-lookup');
        Route::post('/vehicle/what-windscreen-lookup', [VehicleController::class, 'createWhatWindscreenLookup'])->name('vehicle.what-windscreen-lookup');
        Route::get('/vehicle/get-car-model/{id}', [VehicleController::class, 'getCarModel']);
        Route::get('/vehicle/get-glass-positions', [WhatWindscreenApiController::class, 'getGlassPositions'])->name('vehicle.glass-positions');
        Route::get('/vehicle/get-what-windscreen-lookup', [WhatWindscreenApiController::class, 'getWhatWindScreenLookup'])->name('get.windscreen.lookup');

        Route::match(['get', 'post'], '/booking/{type}', [BookingController::class, 'calendar'])->name(
            'booking.calendar'
        );

        Route::match(['get', 'post'], '/all-bookings', [BookingController::class, 'allBookings'])->name(
            'booking.all-bookings'
        );

        Route::post('/booking-save', [BookingController::class, 'saveBoasset-categoriesoking'])->name('booking.save');
        Route::post('/update-technician-booking', [BookingController::class, 'updateTechnicianBooking'])->name('update.technician.booking');
        Route::get('/booking/find/{id}', [BookingController::class, 'findBooking'])->name('booking.find');
        Route::get('/booking/remove/{id}', [BookingController::class, 'removeBooking'])->name('booking.remove');
        Route::get('/booking/change-date/{calendar}/{id}/{date}', [BookingController::class, 'changeBookingDate'])->name(
            'booking.change-date'
        );

        Route::get('/signature/save', [BookingController::class, 'signatureSave']);
        Route::get('/technician/view/{date?}', [BookingController::class, 'technicianView'])->name('technician-view');
        Route::get('/technician/bookings', [BookingController::class, 'technicianBookings'])->name('technician-bookings');
        // Vehicle
        Route::get('/vehicle-management', [VehicleManagementController::class, 'vehicleManagement'])
            ->name('vehicle-management');
        Route::match(
            ['get', 'post'],
            '/vehicle-management/new',
            [VehicleManagementController::class, 'newVehicleManagement']
        )
            ->name('vehicle-management.new-management');
        Route::match(
            ['get', 'put'],
            'vehicle-management/edit/{id}',
            [VehicleManagementController::class, 'editManagement']
        )
            ->name('vehicle-management.edit-management');

        Route::get('/previous/date/{date}', [BookingController::class, 'previousDate'])->name('previous-date');
        Route::get('/next/date/{date}', [BookingController::class, 'nextDate'])->name('next-date');

        // GA Asset
        Route::get('asset', [AssetController::class, 'asset'])
            ->name('ga-asset.asset');
        Route::match(['get', 'post'], 'asset/new', [AssetController::class, 'addAsset'])
            ->name('ga-asset.new-asset');
        Route::match(['get', 'put'], 'asset/edit/{id}', [AssetController::class, 'editAsset'])
            ->name('ga-asset.edit-asset');

        Route::get('asset-categories/index', [AssetController::class, 'index'])
            ->name('ga-asset.asset-categories');
        Route::get('asset-categories', [AssetController::class, 'assetCategories'])
            ->name('get.asset-categories');
        Route::match(['get', 'post'], 'asset-categories/new', [AssetController::class, 'addAssetCategory'])
            ->name('ga-asset.new-asset-categories');
        Route::match(['get', 'put'], 'asset-categories/edit/{id}', [AssetController::class, 'editAssetCategory'])
            ->name('ga-asset.edit-asset-categories');

        //asset  routes
        Route::prefix('asset')->group(function () {
            Route::get('/category/{category_id}/index', [AssetController::class, 'assetIndex'])->name('index.assets');
            Route::get('/category/{category_id}/list', [AssetController::class, 'assetList'])->name('list.assets');
        });

        Route::get('asset/category/type', [AssetController::class, 'assetCategoryType'])
            ->name('ga-asset.asset-category-type');
        Route::match(['get', 'post'], 'asset/category/type/new', [AssetController::class, 'addAssetCategoryType'])
            ->name('ga-asset.new-asset-category-type');
        Route::match(['get', 'put'], 'asset/category/type/edit/{id}', [AssetController::class, 'editAssetCategoryType'])
            ->name('ga-asset.edit-asset-category-type');

        Route::get('vehicle-maintenance', [VehicleManagementController::class, 'vehicleMaintenance'])->name(
            'vehicle-maintenance'
        );
        Route::get('vehicle-event', [VehicleManagementController::class, 'vehicleEvent'])->name('vehicle-event');
        Route::match(
            ['get', 'put'],
            'vehicle-event/edit/{id}',
            [VehicleManagementController::class, 'vehicleEventEdit']
        )
            ->name('vehicle-event.edit');

        // Group Email
        Route::get('/group-email', [GroupEmailController::class, 'index'])->name('group-email');
        Route::match(['get', 'post'], '/group-email/new', [GroupEmailController::class, 'newGroupEmail'])
            ->name('new-group-email');
        Route::get('/group-email/view/{id}', [GroupEmailController::class, 'viewGroupEmail'])
            ->name('view-group-email');

        // Send Log
        Route::get('/send-log', [SendLogController::class, 'index'])->name('send-log');

        // Archive
        Route::get('/archive/customers', [ArchiveController::class, 'customers'])->name('archive.customers');
        Route::get('/archive/customer/unarchive/{id}', [ArchiveController::class, 'unarchiveCustomer'])
            ->name('archive.unarchive-customer');

        Route::get('/archive/categories', [ArchiveController::class, 'categories'])->name('archive.categories');
        Route::get('/archive/categories/unarchive/{id}', [ArchiveController::class, 'unarchiveCategories'])
            ->name('archive.unarchive-categories');

        Route::get('/archive/assets', [ArchiveController::class, 'assets'])->name('archive.assets');
        Route::get('/archive/assets/unarchive/{id}', [ArchiveController::class, 'unarchiveAssets'])
            ->name('archive.unarchive-assets');

        Route::get('/archive/customers', [ArchiveController::class, 'customers'])->name('archive.customers');
        Route::get('/archive/customer/unarchive/{id}', [ArchiveController::class, 'unarchiveCustomer'])
            ->name('archive.unarchive-customer');

        Route::get('/archive/vehicles', [ArchiveController::class, 'vehicles'])->name('archive.vehicles');
        Route::get('/archive/vehicles/unarchive/{id}', [ArchiveController::class, 'unarchiveVehicle'])
            ->name('archive.unarchive-vehicle');

        Route::get('/archive/groups', [ArchiveController::class, 'groups'])->name('archive.groups');
        Route::get('/archive/groups/unarchive/{id}', [ArchiveController::class, 'unarchiveGroup'])
            ->name('archive.unarchive-group');

        Route::get('/archive/vehicle-maintenance-events', [ArchiveController::class, 'vehicleMaintenanceEvents'])
            ->name('archive.vehicle-maintenance-events');
        Route::match(
            ['get', 'put'],
            '/archive/vehicle-maintenance-events/edit/{id}',
            [ArchiveController::class, 'editVehicleMaintenanceEvent']
        )
            ->name('archive.edit-vehicle-maintenance-event');
        Route::get(
            '/archive/vehicle-maintenance-events/unarchive/{id}',
            [ArchiveController::class, 'unarchiveVehicleMaintenanceEvent']
        )
            ->name('archive.unarchive-vehicle-maintenance-event');

        // Admin
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::match(['get', 'put'], '/admin/update-settings', [AdminController::class, 'updateSetting'])
            ->name('admin.update-settings');

        Route::match(['get', 'post'], '/admin/change-password', [AdminController::class, 'changePassword'])
            ->name('admin.change-password');

        Route::get('/admin/buy-text-credit', [AdminController::class, 'buyTextCredit'])->name('admin.buy-text-credit');
        Route::get('/admin/manage-history', [AdminController::class, 'manageHistory'])->name('admin.manage-history');
        Route::match(['get', 'post'], '/admin/manage-history/new', [AdminController::class, 'newHistory'])
            ->name('admin.new-manage-history');
        Route::match(['get', 'put'], '/admin/manage-history/edit/{id}', [AdminController::class, 'editHistory'])
            ->name('admin.edit-manage-history');

        Route::get('/admin/manage-courtesy-car', [AdminController::class, 'manageCourtesyCar'])
            ->name('admin.manage-courtesy-car');
        Route::match(['get', 'post'], '/admin/new-courtesy-car', [AdminController::class, 'newCourtesyCar'])
            ->name('admin.new-courtesy-car');
        /*Route::post('/admin/save-courtesy-car',[AdminController::class,'saveCourtesyCar'])->name('admin.save-courtesy-car');
        Route::get('admin/add-courtesy-car',[AdminController::class,'addCourtesyCar'])->name('admin-add-courtesy-car');*/
        Route::match(
            ['get', 'put'],
            '/admin/manage-courtesy-car/edit/{id}',
            [AdminController::class, 'editCourtesyCar']
        )
            ->name('admin.edit-manage-courtesy-car');

        Route::get('/admin/manage-car-make', [AdminController::class, 'manageCarMake'])->name('admin.manage-car-make');
        Route::match(['get', 'post'], '/admin/manage-car-make/new', [AdminController::class, 'newCarMake'])
            ->name('admin.new-manage-car-make');
        Route::match(['get', 'put'], '/admin/manage-car-make/edit/{id}', [AdminController::class, 'editCarMake'])
            ->name('admin.edit-manage-car-make');

        Route::get('/admin/manage-car-model', [AdminController::class, 'manageCarModel'])->name(
            'admin.manage-car-model'
        );
        Route::match(['get', 'post'], '/admin/manage-car-model/new', [AdminController::class, 'newCarModel'])
            ->name('admin.new-manage-car-model');
        Route::match(['get', 'put'], '/admin/manage-car-model/edit/{id}', [AdminController::class, 'editCarModel'])
            ->name('admin.edit-manage-car-model');

        Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');
        Route::match(['get', 'post'], '/admin/manage-users/new', [AdminController::class, 'newUser'])
            ->name('admin.new-manage-users');
        Route::match(['get', 'put'], '/admin/manage-user/edit/{id}', [AdminController::class, 'editUser'])
            ->name('admin.edit-manage-users');

        Route::get('/admin/manage-staff', [AdminController::class, 'manageStaff'])->name('admin.manage-staff');
        Route::match(['get', 'post'], '/admin/manage-staff/new', [AdminController::class, 'newStaff'])
            ->name('admin.new-manage-staff');
        Route::match(['get', 'put'], '/admin/manage-staff/edit/{id}', [AdminController::class, 'editStaff'])
            ->name('admin.edit-manage-staff');

        Route::get('/admin/vehicle-maintenance', [AdminController::class, 'vehicleMaintenance'])->name(
            'admin.vehicle-maintenance'
        );
        Route::match(
            ['get', 'post'],
            '/admin/vehicle-maintenance/new',
            [AdminController::class, 'newVehicleMaintenance']
        )
            ->name('admin.new-vehicle-maintenance');
        Route::match(
            ['get', 'put'],
            '/admin/vehicle-maintenance/edit/{id}',
            [AdminController::class, 'editVehicleMaintenance']
        )
            ->name('admin.edit-vehicle-maintenance');

        Route::get('/admin/manage-companies', [AdminController::class, 'manageCompanies'])->name(
            'admin.manage-companies'
        );
        Route::get('/admin/manage-glass-supplier', [AdminController::class, 'manageGlassSupplier'])
            ->name('admin.manage-glass-supplier');
        Route::get('/admin/manage-sub-contractors', [AdminController::class, 'manageSubContractor'])
            ->name('admin.manage-sub-contractors');
        Route::get('/admin/manage-bank-holiday', [AdminController::class, 'manageBankHolidays'])
            ->name('admin.manage-bank-holiday');
        Route::match(['get', 'post'], '/admin/manage-bank-holiday/new', [AdminController::class, 'newBankHoliday'])
            ->name('admin.add-manage-bank-holiday');
        Route::match(
            ['get', 'put'],
            '/admin/manage-bank-holiday/edit/{id}',
            [AdminController::class, 'editBankHoliday']
        )
            ->name('admin.edit-manage-bank-holiday');

        Route::match(['get', 'post'], '/admin/manage-absence-period', [AdminController::class, 'manageAbsencePeriod'])
            ->name('admin.manage-absence-period');
        Route::match(['get', 'post'], '/admin/holiday/new', [AdminController::class, 'newHoliday'])
            ->name('admin.new-holiday');
        Route::match(['get', 'put'], '/admin/holiday/edit/{id}', [AdminController::class, 'editHoliday'])
            ->name('admin.edit-holiday');

        Route::get('/admin/view-icomss-invoices', [AdminController::class, 'viewIcomssInvoices'])
            ->name('admin.view-icomss-invoices');
        Route::match(['get', 'post'], '/admin/upload-logo', [AdminController::class, 'uploadLogo'])
            ->name('admin.upload-logo');
        Route::get('/admin/income-report', [AdminController::class, 'incomeReport'])->name('admin.income-report');
        Route::match(['get', 'post'], '/admin/invoice-income-report', [AdminController::class, 'invoiceIncomeReport'])
            ->name('admin.invoice-income-report');

        Route::match(['get', 'post'], '/admin/events/{id}/new', [AdminController::class, 'newEvent'])
            ->name('admin.new-event');
        Route::match(['get', 'put', 'delete'], '/admin/events/edit/{id}', [AdminController::class, 'editEvent'])
            ->name('admin.edit-event');

        Route::get('booking/send-completed/{vehicleHistoryId}', [PDFController::class, 'jobCard']);

        Route::get('/pdf/invoice', [PDFController::class, 'generatePDF'])->name('generate-pdf');
        Route::get('/pdf/job-card/{vehicleHistoryId}', [PDFController::class, 'jobCard'])->name('pdf.job-card');
        Route::get(
            '/pdf/job-card-subscription/{vehicleHistoryId}',
            [PDFController::class, 'jobCardSubscription']
        )->name('pdf.job-card-subscription');
        Route::get(
            '/pdf/booking-invoice/{vehicleHistoryId}/{invoiceDate?}',
            [PDFController::class, 'bookingInvoice']
        )->name('pdf.booking-invoice');
        Route::get(
            '/pdf/email-job-card-subscription/{vehicleHistoryId}',
            [PDFController::class, 'emailJobCardSubscription']
        )->name('pdf.email-job-card-subscription');
        Route::get(
            '/pdf/text-job-card-subscription/{vehicleHistoryId}',
            [PDFController::class, 'textJobCardSubscription']
        )->name('pdf.text-job-card-subscription');

        Route::get('process-transaction', [AdminController::class, 'processTransaction'])->name('processTransaction');
        Route::get('success-transaction', [AdminController::class, 'successTransaction'])->name('successTransaction');
        Route::get('cancel-transaction', [AdminController::class, 'cancelTransaction'])->name('cancelTransaction');

        Route::prefix('api')->group(
            function () {
                include 'api/customer.blade.php';
                include 'api/company.blade.php';
            }
        );
    }
);

// 500 error
$fail = 500;
Route::get(
    '500',
    function () use ($fail) {
        echo $fail;
    }
);
