<?php

use Illuminate\Support\Facades\Route;


Route::middleware('api')->prefix('stapi/v1')->group(function () {

    // Auth Routes
    Route::prefix('userauth')->group(function () {
        require base_path('app/Feature/User/Routes/AuthRoutes.php');
    });

    // Tenant Routes
    Route::prefix('tenants')->group(function () {
        require base_path('app/Feature/Tenant/Routes/TenantRoutes.php');
    });

    Route::prefix('lr')->group(function () {
        require base_path('app/Feature/Lr/Routes/LrRoutes.php');
    });

    Route::prefix('drs')->group(function () {
        require base_path('app/Feature/Drs/Routes/DrsRoutes.php');
    });

    // Customer Routes
    Route::prefix('customers')->group(function () {
        require base_path('app/Feature/Customer/Routes/CustomerRoutes.php');
    });

    // Depot Routes
    // Route::prefix('depot')->group(function () {
    //     require base_path('app/Feature/Depot/Routes/DepotRoutes.php');
    // });

    // Branch Routes
    Route::prefix('branch')->group(function () {
        require base_path('app/Feature/Branch/Routes/BranchRoutes.php');
    });

    Route::prefix('drivermaster')->group(function () {
        require base_path('app/Feature/DriverMaster/Routes/DriverRoutes.php');
    });

    // City Master Routes
    Route::prefix('citymasters')->group(function () {
        require base_path('app/Feature/CityMaster/Routes/CityMasterRoutes.php');
    });

    Route::prefix('vehicle')->group(function () {
        require base_path('app/Feature/Vehicle/Routes/VehicleRoutes.php');
    });

    // Contract Routes
    Route::prefix('Contract')->group(function () {
        Route::prefix('service')->group(function () {
            require base_path('app/Feature/Contract/Routes/Serviceroute.php');
        });
        Route::prefix('Excess')->group(function () {
            require base_path('app/Feature/Contract/Routes/Excessroute.php');
        });
        Route::prefix('defination')->group(function () {
            require base_path('app/Feature/Contract/Routes/slab_defination_route.php');
        });
        Route::prefix('doordelivery')->group(function () {
            require base_path('app/Feature/Contract/Routes/Doordeliveryroutes.php');
        });
        Route::prefix('oda_charge')->group(function () {
            require base_path('app/Feature/Contract/Routes/Oda_charge_routes.php');
        });
        Route::prefix('contractslabrate')->group(function () {
            require base_path('app/Feature/Contract/Routes/ContractSlabRateRoutes.php');
        });
        Route::prefix('AllContract')->group(function () {
            require base_path('app/Feature/Contract/Routes/ContractRoutes.php');
        });
    });



    // Package Type Routes
    Route::prefix('packagetype')->group(function () {
        require base_path('app/Feature/PackageType/Routes/PackageTypeRoutes.php');
    });

    // Payment type
    Route::prefix('paymenttype')->group(function () {
        require base_path('app/Feature/ContractPaymentType/Routes/ContractPaymentTypeRoutes.php');
    });

    // Product Type Routes
    Route::prefix('producttype')->group(function () {
        require base_path('app/Feature/ProductType/Routes/ProductTypeRoutes.php');
    });
    // Vendor Fuel Routes
    Route::prefix('vendorfuel')->group(function () {
        require base_path('app/Feature/VendorFuel/Routes/VendorFuelRoutes.php');
    });
    Route::group(['prefix' => 'hamali'], function () {
        require base_path('app/Feature/Hamali/Routes/HamaliRoutes.php');
    });

    Route::group(['prefix' => 'vehiclecapacitymodel'], function () {
        require base_path('app/Feature/VehicleCapacityModel/Routes/VehicleCapacityModelRoutes.php');
    });

    Route::group(['prefix' => 'vendor'], function () {
        require base_path('app/Feature/Vendor/Routes/VendorRoutes.php');
    });


    Route::group(['prefix' => 'industrytype'], function () {
        require base_path('app/Feature/IndustryType/Routes/IndustryTypeRoutes.php');
    });

    Route::group(['prefix' => 'user'], function () {
        require base_path('app/Feature/User/Routes/UserRoutes.php');
    });

    Route::group(['prefix' => 'groupmaster'], function () {
        require base_path('app/Feature/GroupMaster/Routes/GroupMasterRoutes.php');
    });

    Route::group(['prefix' => 'role'], function () {
        require base_path('app/Feature/User/Routes/RoleRoutes.php');
    });

    Route::group(['prefix' => 'roleprivilege'], function () {
        require base_path('app/Feature/User/Routes/RolePrivilegeRoutes.php');
    });

    Route::group(['prefix' => 'privilege'], function () {
        require base_path('app/Feature/User/Routes/PrivilegeRoutes.php');
    });

      Route::prefix('prn')->group(function () {
        require base_path('app/Feature/PickupRequestNote/Routes/PickupRequestNoteRoutes.php');
    });

    Route::prefix('tyreinventory')->group(function () {
        require base_path('app/Feature/TyreInventoryMaster/Routes/TyreInventoryMasterRoutes.php');
    });

    Route::prefix('india')->group(function () {
        require base_path('app/Feature/India/Routes/IndiaRoutes.php');
    });



    Route::prefix('branchtype')->group(function () {
        require base_path('app/Feature/Branch/Routes/BranchTypeRoutes.php');
    });

    Route::group(['prefix' => 'userbranch'], function () {
        require base_path('app/Feature/UserBranch/Routes/UserBranchRoutes.php');
    });



    Route::prefix('ls')->group(function () {
        require base_path('app/Feature/Ls/Routes/LsRoutes.php');
    });


    Route::prefix('inrouteexpenses')->group(function () {
        require base_path('app/Feature/Expenses/Routes/InRouteExpensesRoutes.php');
    });
});
