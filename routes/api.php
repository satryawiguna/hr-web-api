<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'https'], function () {
    Route::post('register/{group}', 'API\v1\Auth\RegisterController@postRegister');
    Route::post('login', 'API\v1\Auth\LoginController@postLogin');
    Route::post('logout', 'API\v1\Auth\LoginController@postLogout');
    Route::post('token-refresh', 'API\v1\Auth\LoginController@postTokenRefresh');
    Route::post('password/send-reset-link-email', 'API\v1\Auth\ForgotPasswordController@sendResetLinkEmail');

    Route::group(['middleware' => 'auth:api'], function() {
        //<editor-fold desc="#commons region">


        //<editor-fold desc="#application region">

        Route::get('application/list', 'API\v1\Commons\ApplicationController@getApplicationList');
        Route::post('application/list-search', 'API\v1\Commons\ApplicationController@postApplicationListSearch');
        Route::group(['middleware' => 'permission:manage-application'], function () {
            Route::post('application/page-search', 'API\v1\Commons\ApplicationController@postApplicationPageSearch')
                ->middleware('access:manage-application,post');
            Route::get('application/detail/{id}', 'API\v1\Commons\ApplicationController@getApplicationDetail')
                ->middleware('access:manage-application,get');
            Route::post('application/create', 'API\v1\Commons\ApplicationController@postApplicationCreate')
                ->middleware('access:manage-application,create');
            Route::put('application/update', 'API\v1\Commons\ApplicationController@putApplicationUpdate')
                ->middleware('access:manage-application,put');
            Route::delete('application/delete/{id}', 'API\v1\Commons\ApplicationController@deleteApplication')
                ->middleware('access:manage-application,delete');
            Route::delete('application/deletes', 'API\v1\Commons\ApplicationController@deleteBulkApplication')
                ->middleware('access:manage-application,delete');
            Route::put('application/active', 'API\v1\Commons\ApplicationController@putApplicationActive')
                ->middleware('access:manage-application,active');
            Route::get('application/slug/{name}', 'API\v1\Commons\ApplicationController@getApplicationSlug')
                ->middleware('access:manage-application,get');
            /*Route::prefix('application')->group(function () {
                Route::post('list-search/export', 'API\v1\Commons\ApplicationController@postApplicationListSearchExport')
                    ->middleware('access:manage-application,post');
            });*/
        });

        //</editor-fold>


        //<editor-fold desc="#bank region">

        Route::get('bank/list', 'API\v1\Commons\BankController@getBankList');
        Route::post('bank/list-search', 'API\v1\Commons\BankController@postBankListSearch');
        Route::group(['middleware' => 'permission:manage-bank'], function () {
            Route::post('bank/page-search', 'API\v1\Commons\BankController@postBankPageSearch');
            Route::get('bank/detail/{id}', 'API\v1\Commons\BankController@getBankDetail');
            Route::post('bank/create', 'API\v1\Commons\BankController@postBankCreate');
            Route::put('bank/update', 'API\v1\Commons\BankController@putBankUpdate');
            Route::delete('bank/delete/{id}', 'API\v1\Commons\BankController@deleteBank');
            Route::delete('bank/deletes', 'API\v1\Commons\BankController@deleteBulkBank');
            Route::put('bank/active', 'API\v1\Commons\BankController@putBankActive');
            Route::get('bank/slug/{name}', 'API\v1\Commons\BankController@getBankSlug');
            /*Route::prefix('bank')->group(function () {
                Route::post('list-search/export', 'API\v1\Commons\BankController@postBankListSearchExport');
            });*/
        });

        //</editor-fold>


        //<editor-fold desc="#company region">

        Route::get('company/list', 'API\v1\Commons\CompanyController@getCompanyList');
        Route::post('company/list-search', 'API\v1\Commons\CompanyController@postCompanyListSearch');
        Route::post('company/page-search', 'API\v1\Commons\CompanyController@postCompanyPageSearch');
        Route::get('company/detail/{id}', 'API\v1\Commons\CompanyController@getCompanyDetail');
        Route::post('company/create', 'API\v1\Commons\CompanyController@postCompanyCreate');
        Route::put('company/update', 'API\v1\Commons\CompanyController@putCompanyUpdate');
        Route::delete('company/delete/{id}', 'API\v1\Commons\CompanyController@deleteCompany');
        Route::delete('company/deletes', 'API\v1\Commons\CompanyController@deleteBulkCompany');
        Route::put('company/active', 'API\v1\Commons\CompanyController@putCompanyActive');
        Route::get('company/slug/{name}', 'API\v1\Commons\CompanyController@getCompanySlug');
        Route::prefix('company')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\CompanyController@postCompanyListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#company category region">

        Route::get('company-category/list', 'API\v1\Commons\CompanyCategoryController@getCompanyCategoryList');
        Route::post('company-category/list-search', 'API\v1\Commons\CompanyCategoryController@postCompanyCategoryListSearch');
        Route::post('company-category/page-search', 'API\v1\Commons\CompanyCategoryController@postCompanyCategoryPageSearch');
        Route::get('company-category/detail/{id}', 'API\v1\Commons\CompanyCategoryController@getCompanyCategoryDetail');
        Route::post('company-category/create', 'API\v1\Commons\CompanyCategoryController@postCompanyCategoryCreate');
        Route::put('company-category/update', 'API\v1\Commons\CompanyCategoryController@putCompanyCategoryUpdate');
        Route::delete('company-category/delete/{id}', 'API\v1\Commons\CompanyCategoryController@deleteCompanyCategory');
        Route::delete('company-category/deletes', 'API\v1\Commons\CompanyCategoryController@deleteBulkCompanyCategory');
        Route::put('company-category/active', 'API\v1\Commons\CompanyCategoryController@putCompanyCategoryActive');
        Route::get('company-category/slug/{name}', 'API\v1\Commons\CompanyCategoryController@getCompanyCategorySlug');
        Route::prefix('company-category')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\CompanyCategoryController@postCompanyCategoryListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#contract type region">

        Route::get('contract-type/list', 'API\v1\Commons\ContractTypeController@getContractTypeList');
        Route::post('contract-type/list-search', 'API\v1\Commons\ContractTypeController@postContractTypeListSearch');
        Route::post('contract-type/page-search', 'API\v1\Commons\ContractTypeController@postContractTypePageSearch');
        Route::get('contract-type/detail/{id}', 'API\v1\Commons\ContractTypeController@getContractTypeDetail');
        Route::post('contract-type/create', 'API\v1\Commons\ContractTypeController@postContractTypeCreate');
        Route::put('contract-type/update', 'API\v1\Commons\ContractTypeController@putContractTypeUpdate');
        Route::delete('contract-type/delete/{id}', 'API\v1\Commons\ContractTypeController@deleteContractType');
        Route::delete('contract-type/deletes', 'API\v1\Commons\ContractTypeController@deleteBulkContractType');
        Route::put('contract-type/active', 'API\v1\Commons\ContractTypeController@putContractTypeActive');
        Route::get('contract-type/slug/{name}', 'API\v1\Commons\ContractTypeController@getContractTypeSlug');
        Route::prefix('company-type')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\ContractTypeController@postContractTypeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#country region">

        //Route::post('country/list-search', 'API\v1\Commons\CountryController@postCountryListSearch');

        //</editor-fold>


        //<editor-fold desc="#degree region">

        Route::get('degree/list', 'API\v1\Commons\DegreeController@getDegreeList');
        Route::post('degree/list-search', 'API\v1\Commons\DegreeController@postDegreeListSearch');
        Route::post('degree/page-search', 'API\v1\Commons\DegreeController@postDegreePageSearch');
        Route::get('degree/detail/{id}', 'API\v1\Commons\DegreeController@getDegreeDetail');
        Route::post('degree/create', 'API\v1\Commons\DegreeController@postDegreeCreate');
        Route::put('degree/update', 'API\v1\Commons\DegreeController@putDegreeUpdate');
        Route::delete('degree/delete/{id}', 'API\v1\Commons\DegreeController@deleteDegree');
        Route::delete('degree/deletes', 'API\v1\Commons\DegreeController@deleteBulkDegree');
        Route::put('degree/active', 'API\v1\Commons\DegreeController@putDegreeActive');
        Route::get('degree/slug/{name}', 'API\v1\Commons\DegreeController@getDegreeSlug');
        Route::prefix('degree')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\DegreeController@postDegreeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#employee number scale region">

        Route::get('employee-number-scale/list', 'API\v1\Commons\EmployeeNumberScaleController@getEmployeeNumberScaleList');
        Route::post('employee-number-scale/list-search', 'API\v1\Commons\EmployeeNumberScaleController@postEmployeeNumberScaleListSearch');
        Route::post('employee-number-scale/page-search', 'API\v1\Commons\EmployeeNumberScaleController@postEmployeeNumberScalePageSearch');
        Route::get('employee-number-scale/detail/{id}', 'API\v1\Commons\EmployeeNumberScaleController@getEmployeeNumberScaleDetail');
        Route::post('employee-number-scale/create', 'API\v1\Commons\EmployeeNumberScaleController@postEmployeeNumberScaleCreate');
        Route::put('employee-number-scale/update', 'API\v1\Commons\EmployeeNumberScaleController@putEmployeeNumberScaleUpdate');
        Route::delete('employee-number-scale/delete/{id}', 'API\v1\Commons\EmployeeNumberScaleController@deleteEmployeeNumberScale');
        Route::delete('employee-number-scale/deletes', 'API\v1\Commons\EmployeeNumberScaleController@deleteBulkEmployeeNumberScale');
        Route::put('employee-number-scale/active', 'API\v1\Commons\EmployeeNumberScaleController@putEmployeeNumberScaleActive');
        Route::get('employee-number-scale/slug/{name}', 'API\v1\Commons\EmployeeNumberScaleController@getEmployeeNumberScaleSlug');
        Route::prefix('employee-number-scale')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\EmployeeNumberScaleController@postEmployeeNumberScaleListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#gender region">

        Route::get('gender/list', 'API\v1\Commons\GenderController@getGenderList');
        Route::post('gender/list-search', 'API\v1\Commons\GenderController@postGenderListSearch');
        Route::post('gender/page-search', 'API\v1\Commons\GenderController@postGenderPageSearch');
        Route::get('gender/detail/{id}', 'API\v1\Commons\GenderController@getGenderDetail');
        Route::post('gender/create', 'API\v1\Commons\GenderController@postGenderCreate');
        Route::put('gender/update', 'API\v1\Commons\GenderController@putGenderUpdate');
        Route::delete('gender/delete/{id}', 'API\v1\Commons\GenderController@deleteGender');
        Route::delete('gender/deletes', 'API\v1\Commons\GenderController@deleteBulkGender');
        Route::put('gender/active', 'API\v1\Commons\GenderController@putGenderActive');
        Route::get('gender/slug/{name}', 'API\v1\Commons\GenderController@getGenderSlug');
        Route::prefix('gender')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\GenderController@postGenderListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#major region">

        Route::get('major/list', 'API\v1\Commons\MajorController@getMajorList');
        Route::post('major/list-search', 'API\v1\Commons\MajorController@postMajorListSearch');
        Route::post('major/page-search', 'API\v1\Commons\MajorController@postMajorPageSearch');
        Route::get('major/detail/{id}', 'API\v1\Commons\MajorController@getMajorDetail');
        Route::post('major/create', 'API\v1\Commons\MajorController@postMajorCreate');
        Route::put('major/update', 'API\v1\Commons\MajorController@putMajorUpdate');
        Route::delete('major/delete/{id}', 'API\v1\Commons\MajorController@deleteMajor');
        Route::delete('major/deletes', 'API\v1\Commons\MajorController@deleteBulkMajor');
        Route::put('major/active', 'API\v1\Commons\MajorController@putMajorActive');
        Route::get('major/slug/{name}', 'API\v1\Commons\MajorController@getMajorSlug');
        Route::prefix('major')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\MajorController@postMajorListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#marital status region">

        Route::get('marital-status/list', 'API\v1\Commons\MaritalStatusController@getMaritalStatusList');
        Route::post('marital-status/list-search', 'API\v1\Commons\MaritalStatusController@postMaritalStatusListSearch');
        Route::post('marital-status/page-search', 'API\v1\Commons\MaritalStatusController@postMaritalStatusPageSearch');
        Route::get('marital-status/detail/{id}', 'API\v1\Commons\MaritalStatusController@getMaritalStatusDetail');
        Route::post('marital-status/create', 'API\v1\Commons\MaritalStatusController@postMaritalStatusCreate');
        Route::put('marital-status/update', 'API\v1\Commons\MaritalStatusController@putMaritalStatusUpdate');
        Route::delete('marital-status/delete/{id}', 'API\v1\Commons\MaritalStatusController@deleteMaritalStatus');
        Route::delete('marital-status/deletes', 'API\v1\Commons\MaritalStatusController@deleteBulkMaritalStatus');
        Route::put('marital-status/active', 'API\v1\Commons\MaritalStatusController@putMaritalStatusActive');
        Route::get('marital-status/slug/{name}', 'API\v1\Commons\MaritalStatusController@getMaritalStatusSlug');
        Route::prefix('marital-status')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\MaritalStatusController@postMaritalStatusListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#office region">

        Route::get('office/list', 'API\v1\Commons\OfficeController@getOfficeList');
        Route::post('office/list-search', 'API\v1\Commons\OfficeController@postOfficeListSearch');
        Route::post('office/page-search', 'API\v1\Commons\OfficeController@postOfficePageSearch');
        Route::get('office/detail/{id}', 'API\v1\Commons\OfficeController@getOfficeDetail');
        Route::post('office/create', 'API\v1\Commons\OfficeController@postOfficeCreate');
        Route::put('office/update', 'API\v1\Commons\OfficeController@putOfficeUpdate');
        Route::delete('office/delete/{id}', 'API\v1\Commons\OfficeController@deleteOffice');
        Route::delete('office/deletes', 'API\v1\Commons\OfficeController@deleteBulkOffice');
        Route::put('office/active', 'API\v1\Commons\OfficeController@putOfficeActive');
        Route::get('office/slug/{company_id}/{name}', 'API\v1\Commons\OfficeController@getOfficeSlug');
        Route::prefix('office')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\OfficeController@postOfficeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#religion region">

        Route::get('religion/list', 'API\v1\Commons\ReligionController@getReligionList');
        Route::post('religion/list-search', 'API\v1\Commons\ReligionController@postReligionListSearch');
        Route::post('religion/page-search', 'API\v1\Commons\ReligionController@postReligionPageSearch');
        Route::get('religion/detail/{id}', 'API\v1\Commons\ReligionController@getReligionDetail');
        Route::post('religion/create', 'API\v1\Commons\ReligionController@postReligionCreate');
        Route::put('religion/update', 'API\v1\Commons\ReligionController@putReligionUpdate');
        Route::delete('religion/delete/{id}', 'API\v1\Commons\ReligionController@deleteReligion');
        Route::delete('religion/deletes', 'API\v1\Commons\ReligionController@deleteBulkReligion');
        Route::put('religion/active', 'API\v1\Commons\ReligionController@putReligionActive');
        Route::get('religion/slug/{name}', 'API\v1\Commons\ReligionController@getReligionSlug');
        Route::prefix('religion')->group(function () {
            Route::post('list-search/export', 'API\v1\Commons\ReligionController@postReligionListSearchExport');
        });

        //</editor-fold>

        //<editor-fold desc="#gender region">

        Route::get('vacancy-categories', 'API\v1\Commons\VacancyCategoryController@getVacancyCategoryList');
        Route::post('vacancy-categories/list-search', 'API\v1\Commons\VacancyCategoryController@postVacancyCategoryListSearch');
        Route::post('vacancy-categories/page-search', 'API\v1\Commons\VacancyCategoryController@postVacancyCategoryPageSearch');
        Route::post('vacancy-category', 'API\v1\Commons\VacancyCategoryController@postVacancyCategoryCreate');
        Route::put('vacancy-category', 'API\v1\Commons\VacancyCategoryController@putVacancyCategoryUpdate');
        Route::delete('vacancy-category/{id}', 'API\v1\Commons\VacancyCategoryController@deleteVacancyCategory');
        Route::delete('vacancy-categories', 'API\v1\Commons\VacancyCategoryController@deleteBulkVacancyCategory');
        Route::get('vacancy-category/slug/{name}', 'API\v1\Commons\VacancyCategoryController@getVacancyCategorySlug');

        //</editor-fold>

        //<editor-fold desc="#gender region">

        Route::get('vacancy-locations', 'API\v1\Commons\VacancyLocationController@getVacancyLocationList');
        Route::post('vacancy-locations/list-search', 'API\v1\Commons\VacancyLocationController@postVacancyLocationListSearch');
        Route::post('vacancy-locations/page-search', 'API\v1\Commons\VacancyLocationController@postVacancyLocationPageSearch');
        Route::post('vacancy-location', 'API\v1\Commons\VacancyLocationController@postVacancyLocationCreate');
        Route::put('vacancy-location', 'API\v1\Commons\VacancyLocationController@putVacancyLocationUpdate');
        Route::delete('vacancy-location/{id}', 'API\v1\Commons\VacancyLocationController@deleteVacancyLocation');
        Route::delete('vacancy-locations', 'API\v1\Commons\VacancyLocationController@deleteBulkVacancyLocation');
        Route::get('vacancy-location/slug/{name}', 'API\v1\Commons\VacancyLocationController@getVacancyLocationSlug');

        //</editor-fold>

        //<editor-fold desc="#">

        Route::get('skills', 'API\v1\Commons\SkillController@getSkillList');
        Route::post('skills/list-search', 'API\v1\Commons\SkillController@postSkillListSearch');
        Route::post('skills/page-search', 'API\v1\Commons\SkillController@postSkillPageSearch');
        Route::post('skill', 'API\v1\Commons\SkillController@postSkillCreate');
        Route::put('skill', 'API\v1\Commons\SkillController@putSkillUpdate');
        Route::delete('skill/{id}', 'API\v1\Commons\SkillController@deleteSkill');
        Route::delete('skills', 'API\v1\Commons\SkillController@deleteBulkSkill');
        Route::get('skill/slug/{name}', 'API\v1\Commons\SkillController@getSkillSlug');

        //</editor-fold>

        //<editor-fold desc="#">

        Route::get('recruitment-stages', 'API\v1\HumanResources\MasterData\RecruitmentStageController@getRecruitmentStageList');
        Route::post('recruitment-stages/list-search', 'API\v1\HumanResources\MasterData\RecruitmentStageController@postRecruitmentStageListSearch');
        Route::post('recruitment-stages/page-search', 'API\v1\HumanResources\MasterData\RecruitmentStageController@postRecruitmentStagePageSearch');
        Route::post('recruitment-stage', 'API\v1\HumanResources\MasterData\RecruitmentStageController@postRecruitmentStageCreate');
        Route::put('recruitment-stage', 'API\v1\HumanResources\MasterData\RecruitmentStageController@putRecruitmentStageUpdate');
        Route::delete('recruitment-stage/{id}', 'API\v1\HumanResources\MasterData\RecruitmentStageController@deleteRecruitmentStage');
        Route::delete('recruitment-stages', 'API\v1\HumanResources\MasterData\RecruitmentStageController@deleteBulkRecruitmentStage');
        Route::get('recruitment-stage/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\RecruitmentStageController@getRecruitmentStageSlug');

        //</editor-fold>

        //<editor-fold desc="#">

        Route::get('recruitment-schedules', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@getRecruitmentScheduleList');
        Route::post('recruitment-schedules/list-search', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@postRecruitmentScheduleListSearch');
        Route::post('recruitment-schedules/page-search', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@postRecruitmentSchedulePageSearch');
        Route::post('recruitment-schedule', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@postRecruitmentScheduleCreate');
        Route::put('recruitment-schedule', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@putRecruitmentScheduleUpdate');
        Route::delete('recruitment-schedule/{id}', 'API\v1\HumanResources\Reqruitment\RecruitmentScheduleController@deleteRecruitmentSchedule');

        //</editor-fold>


        //<editor-fold desc="Country">

        Route::get('countries', 'API\v1\Area\CountryController@getCountryList');
        Route::post('country/list-search', 'API\v1\Area\CountryController@postCountryListSearch');
        Route::post('country/page-search', 'API\v1\Area\CountryController@postCountryPageSearch');
        Route::post('country', 'API\v1\Area\CountryController@postCountryCreate');
        Route::put('country', 'API\v1\Area\CountryController@putCountryUpdate');
        Route::delete('country/{id}', 'API\v1\Area\CountryController@deleteCountry');

        //</editor-fold>

        //<editor-fold desc="State">

        Route::get('states', 'API\v1\Area\StateController@getStateList');
        Route::post('state/list-search', 'API\v1\Area\StateController@postStateListSearch');
        Route::post('state/page-search', 'API\v1\Area\StateController@postStatePageSearch');
        Route::post('state', 'API\v1\Area\StateController@postStateCreate');
        Route::put('state', 'API\v1\Area\StateController@putStateUpdate');
        Route::delete('state/{id}', 'API\v1\Area\StateController@deleteState');

        //</editor-fold>

        //<editor-fold desc="City">

        Route::get('cities', 'API\v1\Area\CityController@getCityList');
        Route::post('city/list-search', 'API\v1\Area\CityController@postCityListSearch');
        Route::post('city/page-search', 'API\v1\Area\CityController@postCityPageSearch');
        Route::post('city', 'API\v1\Area\CityController@postCityCreate');
        Route::put('city', 'API\v1\Area\CityController@putCityUpdate');
        Route::delete('city/{id}', 'API\v1\Area\CityController@deleteCity');

        //</editor-fold>


        //<editor-fold desc="#role region">

        Route::group(['middleware' => 'permission:manage-role'], function () {
            Route::get('role/list', 'API\v1\Commons\RoleController@getRoleList')
                ->middleware('access:manage-role,get');
            Route::post('role/list-search', 'API\v1\Commons\RoleController@postRoleListSearch')
                ->middleware('access:manage-role,post');
            Route::post('role/page-search', 'API\v1\Commons\RoleController@postRolePageSearch')
                ->middleware('access:manage-role,post');
            Route::get('role/detail/{id}', 'API\v1\Commons\RoleController@getRoleDetail')
                ->middleware('access:manage-role,get');
            Route::prefix('role/detail/{id}')->group(function () {
                Route::get('/permission', 'API\v1\Commons\RoleController@getRolePermission')
                    ->middleware('access:manage-role,get');
            });
            Route::post('role/create', 'API\v1\Commons\RoleController@postRoleCreate')
                ->middleware('access:manage-role,create');
            Route::put('role/update', 'API\v1\Commons\RoleController@putRoleUpdate')
                ->middleware('access:manage-role,put');
            Route::prefix('role/update')->group(function () {
                Route::put('/permission', 'API\v1\Commons\RoleController@putRoleUpdatePermission')
                    ->middleware('access:manage-role,put');
            });
            Route::delete('role/delete/{id}', 'API\v1\Commons\RoleController@deleteRole')
                ->middleware('access:manage-role,delete');
            Route::delete('role/deletes', 'API\v1\Commons\RoleController@deleteBulkRole')
                ->middleware('access:manage-role,delete');
            Route::put('role/active', 'API\v1\Commons\RoleController@putRoleActive')
                ->middleware('access:manage-role,active');
            Route::get('role/slug/{name}', 'API\v1\Commons\RoleController@getRoleSlug')
                ->middleware('access:manage-role,get');
            /*Route::prefix('role')->group(function () {
                Route::post('list-search/export', 'API\v1\Commons\RoleController@postRoleListSearchExport');
            });*/
        });

        //</editor-fold>


        //<editor-fold desc="#group region">

        Route::get('group/list', 'API\v1\Commons\GroupController@getGroupList');
        Route::post('group/list-search', 'API\v1\Commons\GroupController@postGroupListSearch');
        Route::post('group/page-search', 'API\v1\Commons\GroupController@postGroupPageSearch');
        Route::get('group/detail/{id}', 'API\v1\Commons\GroupController@getGroupDetail');
        Route::post('group/create', 'API\v1\Commons\GroupController@postGroupCreate');
        Route::put('group/update', 'API\v1\Commons\GroupController@putGroupUpdate');
        Route::delete('group/delete/{id}', 'API\v1\Commons\GroupController@deleteGroup');
        Route::delete('group/deletes', 'API\v1\Commons\GroupController@deleteBulkGroup');
        Route::put('group/active', 'API\v1\Commons\GroupController@putGroupActive');
        Route::get('group/slug/{name}', 'API\v1\Commons\GroupController@getGroupSlug');

        //</editor-fold>


        //<editor-fold desc="#access region">

        Route::group(['middleware' => 'permission:manage-access'], function () {
            Route::get('access/list', 'API\v1\Commons\AccessController@getAccessList')
                ->middleware('access:manage-access,get');
            Route::post('access/list-search', 'API\v1\Commons\AccessController@postAccessListSearch')
                ->middleware('access:manage-access,post');
            Route::post('access/page-search', 'API\v1\Commons\AccessController@postAccessPageSearch')
                ->middleware('access:manage-access,post');
            Route::get('access/detail/{id}', 'API\v1\Commons\AccessController@getAccessDetail')
                ->middleware('access:manage-access,get');
            Route::post('access/create', 'API\v1\Commons\AccessController@postAccessCreate')
                ->middleware('access:manage-access,create');
            Route::put('access/update', 'API\v1\Commons\AccessController@putAccessUpdate')
                ->middleware('access:manage-access,put');
            Route::delete('access/delete/{id}', 'API\v1\Commons\AccessController@deleteAccess')
                ->middleware('access:manage-access,delete');
            Route::delete('access/deletes', 'API\v1\Commons\AccessController@deleteBulkAccess')
                ->middleware('access:manage-access,delete');
            Route::put('access/active', 'API\v1\Commons\AccessController@putAccessActive')
                ->middleware('access:manage-access,active');
            Route::get('access/slug/{name}', 'API\v1\Commons\AccessController@getAccessSlug')
                ->middleware('access:manage-access,get');
        });

        //</editor-fold>


        //<editor-fold desc="#permission region">

        Route::group(['middleware' => 'permission:manage-permission'], function () {
            Route::get('permission/list', 'API\v1\Commons\PermissionController@getPermissionList')
                ->middleware('access:manage-permission,get');
            Route::post('permission/list-search', 'API\v1\Commons\PermissionController@postPermissionListSearch')
                ->middleware('access:manage-permission,post');
            Route::post('permission/page-search', 'API\v1\Commons\PermissionController@postPermissionPageSearch')
                ->middleware('access:manage-permission,post');
            Route::get('permission/detail/{id}', 'API\v1\Commons\PermissionController@getPermissionDetail')
                ->middleware('access:manage-permission,get');
            Route::prefix('permission/detail/{id}')->group(function () {
                Route::get('/access', 'API\v1\Commons\PermissionController@getPermissionAccess')
                    ->middleware('access:manage-permission,get');
            });
            Route::post('permission/create', 'API\v1\Commons\PermissionController@postPermissionCreate')
                ->middleware('access:manage-permission,create');
            Route::put('permission/update', 'API\v1\Commons\PermissionController@putPermissionUpdate')
                ->middleware('access:manage-permission,put');
            Route::prefix('permission/update')->group(function () {
                Route::put('/access', 'API\v1\Commons\PermissionController@putPermissionUpdateAccess')
                    ->middleware('access:manage-permission,put');
            });
            Route::delete('permission/delete/{id}', 'API\v1\Commons\PermissionController@deletePermission')
                ->middleware('access:manage-permission,delete');
            Route::delete('permission/deletes', 'API\v1\Commons\PermissionController@deleteBulkPermission')
                ->middleware('access:manage-permission,delete');
            Route::put('permission/active', 'API\v1\Commons\PermissionController@putPermissionActive')
                ->middleware('access:manage-permission,active');
            Route::get('permission/slug/{name}', 'API\v1\Commons\PermissionController@getPermissionSlug')
                ->middleware('access:manage-permission,get');
        });

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#human resources region">


        //<editor-fold desc="#element region">

        Route::get('element/list', 'API\v1\HumanResources\Element\ElementController@getElementList');
        Route::post('element/list-search', 'API\v1\HumanResources\Element\ElementController@postElementListSearch');
        Route::post('element/page-search', 'API\v1\HumanResources\Element\ElementController@postElementPageSearch');
        Route::get('element/detail/{id}', 'API\v1\HumanResources\Element\ElementController@getElementDetail');
        Route::post('element/create', 'API\v1\HumanResources\Element\ElementController@postElementCreate');
        Route::put('element/update', 'API\v1\HumanResources\Element\ElementController@putElementUpdate');
        Route::delete('element/delete/{id}', 'API\v1\HumanResources\Element\ElementController@deleteElement');
        Route::delete('element/deletes', 'API\v1\HumanResources\Element\ElementController@deleteBulkElement');
        Route::get('element/slug/{name}', 'API\v1\HumanResources\Element\ElementController@getElementSlug');
        Route::prefix('element')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Element\ElementController@postElementListSearchExport');
        });


        //<editor-fold desc="#element entry region">

        Route::get('element-entry/list', 'API\v1\HumanResources\Element\ElementEntryController@getElementEntryList');
        Route::post('element-entry/list-search', 'API\v1\HumanResources\Element\ElementEntryController@postElementEntryListSearch');
        Route::post('element-entry/page-search', 'API\v1\HumanResources\Element\ElementEntryController@postElementEntryPageSearch');
        Route::get('element-entry/detail/{id}', 'API\v1\HumanResources\Element\ElementEntryController@getElementEntryDetail');
        Route::post('element-entry/create', 'API\v1\HumanResources\Element\ElementEntryController@postElementEntryCreate');
        Route::put('element-entry/update', 'API\v1\HumanResources\Element\ElementEntryController@putElementEntryUpdate');
        Route::delete('element-entry/delete/{id}', 'API\v1\HumanResources\Element\ElementEntryController@deleteElementEntry');
        Route::delete('element-entry/deletes', 'API\v1\HumanResources\Element\ElementEntryController@deleteBulkElementEntry');
        Route::prefix('element-entry')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Element\ElementEntryController@postElementEntryListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#element entry value region">

        Route::get('element-entry-value/list', 'API\v1\HumanResources\Element\ElementEntryValueController@getElementEntryValueList');
        Route::post('element-entry-value/list-search', 'API\v1\HumanResources\Element\ElementEntryValueController@postElementEntryValueListSearch');
        Route::post('element-entry-value/page-search', 'API\v1\HumanResources\Element\ElementEntryValueController@postElementEntryValuePageSearch');
        Route::get('element-entry-value/detail/{id}', 'API\v1\HumanResources\Element\ElementEntryValueController@getElementEntryValueDetail');
        Route::post('element-entry-value/create', 'API\v1\HumanResources\Element\ElementEntryValueController@postElementEntryValueCreate');
        Route::put('element-entry-value/update', 'API\v1\HumanResources\Element\ElementEntryValueController@putElementEntryValueUpdate');
        Route::delete('element-entry-value/delete/{id}', 'API\v1\HumanResources\Element\ElementEntryValueController@deleteElementEntryValue');
        Route::delete('element-entry-value/deletes', 'API\v1\HumanResources\Element\ElementEntryValueController@deleteBulkElementEntryValue');
        Route::prefix('element-entry-value')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Element\ElementEntryValueController@postElementEntryValueListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#element value region">

        Route::get('element-value/list', 'API\v1\HumanResources\Element\ElementValueController@getElementValueList');
        Route::post('element-value/list-search', 'API\v1\HumanResources\Element\ElementValueController@postElementValueListSearch');
        Route::post('element-value/page-search', 'API\v1\HumanResources\Element\ElementValueController@postElementValuePageSearch');
        Route::get('element-value/detail/{id}', 'API\v1\HumanResources\Element\ElementValueController@getElementValueDetail');
        Route::post('element-value/create', 'API\v1\HumanResources\Element\ElementValueController@postElementValueCreate');
        Route::put('element-value/update', 'API\v1\HumanResources\Element\ElementValueController@putElementValueUpdate');
        Route::delete('element-value/delete/{id}', 'API\v1\HumanResources\Element\ElementValueController@deleteElementValue');
        Route::delete('element-value/deletes', 'API\v1\HumanResources\Element\ElementValueController@deleteBulkElementValue');
        Route::get('element-value/slug/{name}', 'API\v1\HumanResources\Element\ElementValueController@getElementValueSlug');
        Route::prefix('element-value')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Element\ElementValueController@postElementValueListSearchExport');
        });

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#formula region">

        Route::get('formula/list', 'API\v1\HumanResources\Formula\FormulaController@getFormulaList');
        Route::post('formula/list-search', 'API\v1\HumanResources\Formula\FormulaController@postFormulaListSearch');
        Route::post('formula/page-search', 'API\v1\HumanResources\Formula\FormulaController@postFormulaPageSearch');
        Route::get('formula/detail/{id}', 'API\v1\HumanResources\Formula\FormulaController@getFormulaDetail');
        Route::post('formula/create', 'API\v1\HumanResources\Formula\FormulaController@postFormulaCreate');
        Route::put('formula/update', 'API\v1\HumanResources\Formula\FormulaController@putFormulaUpdate');
        Route::delete('formula/delete/{id}', 'API\v1\HumanResources\Formula\FormulaController@deleteFormula');
        Route::delete('formula/deletes', 'API\v1\HumanResources\Formula\FormulaController@deleteBulkFormula');
        Route::get('formula/slug/{name}', 'API\v1\HumanResources\Formula\FormulaController@getFormulaSlug');
        Route::prefix('formula')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Formula\FormulaController@postFormulaListSearchExport');
        });


        //<editor-fold desc="#formula category region">

        Route::get('formula-category/list', 'API\v1\HumanResources\Formula\FormulaCategoryController@getFormulaCategoryList');
        Route::post('formula-category/list-search', 'API\v1\HumanResources\Formula\FormulaCategoryController@postFormulaCategoryListSearch');
        Route::post('formula-category/page-search', 'API\v1\HumanResources\Formula\FormulaCategoryController@postFormulaCategoryPageSearch');
        Route::get('formula-category/detail/{id}', 'API\v1\HumanResources\Formula\FormulaCategoryController@getFormulaCategoryDetail');
        Route::post('formula-category/create', 'API\v1\HumanResources\Formula\FormulaCategoryController@postFormulaCategoryCreate');
        Route::put('formula-category/update', 'API\v1\HumanResources\Formula\FormulaCategoryController@putFormulaCategoryUpdate');
        Route::delete('formula-category/delete/{id}', 'API\v1\HumanResources\Formula\FormulaCategoryController@deleteFormulaCategory');
        Route::delete('formula-category/deletes', 'API\v1\HumanResources\Formula\FormulaCategoryController@deleteBulkFormulaCategory');
        Route::get('formula-category/slug/{name}', 'API\v1\HumanResources\Formula\FormulaCategoryController@getFormulaCategorySlug');
        Route::prefix('formula-category')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Formula\FormulaCategoryController@postFormulaCategoryListSearchExport');
        });

        //</editor-fold>

        //<editor-fold desc="#vacancy mutation region">

        Route::get('vacancies', 'API\v1\HumanResources\Vacancy\VacancyController@getVacancyList');
        Route::post('vacancy/list-search', 'API\v1\HumanResources\Vacancy\VacancyController@postVacancyListSearch');
        Route::post('vacancy/page-search', 'API\v1\HumanResources\Vacancy\VacancyController@postVacancyPageSearch');
        Route::post('vacancy', 'API\v1\HumanResources\Vacancy\VacancyController@postVacancyCreate');
        Route::put('vacancy', 'API\v1\HumanResources\Vacancy\VacancyController@putVacancyUpdate');
        Route::put('vacancy/{id}/publish', 'API\v1\HumanResources\Vacancy\VacancyController@putVacancyPublish');
        Route::put('vacancy/{id}/draft', 'API\v1\HumanResources\Vacancy\VacancyController@putVacancyDraft');
        Route::put('vacancy/{id}/pending', 'API\v1\HumanResources\Vacancy\VacancyController@putVacancyPending');
        Route::delete('vacancy/{id}', 'API\v1\HumanResources\Vacancy\VacancyController@deleteVacancy');
        Route::delete('vacancies', 'API\v1\HumanResources\Vacancy\VacancyController@deleteBulkVacancy');

        //</editor-fold>

        //<editor-fold desc="#vacancy applicant mutation region">
        Route::post('recruitment/apply', 'API\v1\HumanResources\Reqruitment\RecruitmentController@postVacancyApplicantCreate');

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#master data region">


        //<editor-fold desc="#base salary custom type region">

        Route::get('base-salary-custom-type/list', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@postBaseSalaryCustomTypeList');
        Route::post('base-salary-custom-type/list-search', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@postBaseSalaryCustomTypeListSearch');
        Route::post('base-salary-custom-type/page-search', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@postBaseSalaryCustomTypePageSearch');
        Route::get('base-salary-custom-type/detail/{id}', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@getBaseSalaryCustomTypeDetail');
        Route::post('base-salary-custom-type/create', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@postBaseSalaryCustomTypeCreate');
        Route::put('base-salary-custom-type/update', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@putBaseSalaryCustomTypeUpdate');
        Route::delete('base-salary-custom-type/delete/{id}', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@deleteBaseSalaryCustomType');
        Route::delete('base-salary-custom-type/deletes', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@deleteBulkBaseSalaryCustomTypeValue');
        Route::put('base-salary-custom-type/active', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@putBaseSalaryCustomTypeActive');
        Route::get('base-salary-custom-type/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@getBaseSalaryCustomTypeSlug');
        Route::prefix('base-salary-custom-type')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\BaseSalaryCustomTypeController@postBaseSalaryCustomTypeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#competence region">

        Route::get('competence/list', 'API\v1\HumanResources\MasterData\CompetenceController@getCompetenceList');
        Route::post('competence/list-search', 'API\v1\HumanResources\MasterData\CompetenceController@postCompetenceListSearch');
        Route::post('competence/page-search', 'API\v1\HumanResources\MasterData\CompetenceController@postCompetencePageSearch');
        Route::get('competence/detail/{id}', 'API\v1\HumanResources\MasterData\CompetenceController@getCompetenceDetail');
        Route::post('competence/create', 'API\v1\HumanResources\MasterData\CompetenceController@postCompetenceCreate');
        Route::put('competence/update', 'API\v1\HumanResources\MasterData\CompetenceController@putCompetenceUpdate');
        Route::delete('competence/delete/{id}', 'API\v1\HumanResources\MasterData\CompetenceController@deleteCompetence');
        Route::delete('competence/deletes', 'API\v1\HumanResources\MasterData\CompetenceController@deleteBulkCompetence');
        Route::put('competence/active', 'API\v1\HumanResources\MasterData\CompetenceController@putCompetenceActive');
        Route::get('competence/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\CompetenceController@getCompetenceSlug');
        Route::prefix('competence')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\CompetenceController@postCompetenceListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#employee loan type region">

        Route::get('employee-loan-type/list', 'API\v1\Commons\EmployeeLoanTypeController@postEmployeeLoanTypeList');
        Route::post('employee-loan-type/list-search', 'API\v1\Commons\EmployeeLoanTypeController@postEmployeeLoanTypeListSearch');
        Route::post('employee-loan-type/page-search', 'API\v1\Commons\EmployeeLoanTypeController@postEmployeeLoanTypePageSearch');
        Route::get('employee-loan-type/detail/{id}', 'API\v1\Commons\EmployeeLoanTypeController@getEmployeeLoanTypeDetail');
        Route::post('employee-loan-type/create', 'API\v1\Commons\EmployeeLoanTypeController@postEmployeeLoanTypeCreate');
        Route::put('employee-loan-type/update', 'API\v1\Commons\EmployeeLoanTypeController@putEmployeeLoanTypeUpdate');
        Route::delete('employee-loan-type/delete/{id}', 'API\v1\Commons\EmployeeLoanTypeController@deleteEmployeeLoanType');
        Route::put('employee-loan-type/active', 'API\v1\Commons\EmployeeLoanTypeController@putEmployeeLoanTypeActive');
        Route::get('employee-loan-type/slug/{company_id}/{name}', 'API\v1\Commons\EmployeeLoanTypeController@getEmployeeLoanTypeSlug');

        //</editor-fold>


        //<editor-fold desc="#grade region">

        Route::get('grade/list', 'API\v1\HumanResources\MasterData\GradeController@getGradeList');
        Route::post('grade/list-search', 'API\v1\HumanResources\MasterData\GradeController@postGradeListSearch');
        Route::post('grade/page-search', 'API\v1\HumanResources\MasterData\GradeController@postGradePageSearch');
        Route::get('grade/detail/{id}', 'API\v1\HumanResources\MasterData\GradeController@getGradeDetail');
        Route::post('grade/create', 'API\v1\HumanResources\MasterData\GradeController@postGradeCreate');
        Route::put('grade/update', 'API\v1\HumanResources\MasterData\GradeController@putGradeUpdate');
        Route::delete('grade/delete/{id}', 'API\v1\HumanResources\MasterData\GradeController@deleteGrade');
        Route::delete('grade/deletes', 'API\v1\HumanResources\MasterData\GradeController@deleteBulkGrade');
        Route::put('grade/active', 'API\v1\HumanResources\MasterData\GradeController@putGradeActive');
        Route::get('grade/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\GradeController@getGradeSlug');
        Route::prefix('grade')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\GradeController@postGradeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#letter type region">

        Route::get('letter-type/list', 'API\v1\HumanResources\MasterData\LetterTypeController@getLetterTypeList');
        Route::post('letter-type/list-search', 'API\v1\HumanResources\MasterData\LetterTypeController@postLetterTypeListSearch');
        Route::post('letter-type/page-search', 'API\v1\HumanResources\MasterData\LetterTypeController@postLetterTypePageSearch');
        Route::get('letter-type/detail/{id}', 'API\v1\HumanResources\MasterData\LetterTypeController@getLetterTypeDetail');
        Route::post('letter-type/create', 'API\v1\HumanResources\MasterData\LetterTypeController@postLetterTypeCreate');
        Route::put('letter-type/update', 'API\v1\HumanResources\MasterData\LetterTypeController@putLetterTypeUpdate');
        Route::delete('letter-type/delete/{id}', 'API\v1\HumanResources\MasterData\LetterTypeController@deleteLetterType');
        Route::delete('letter-type/deletes', 'API\v1\HumanResources\MasterData\LetterTypeController@deleteBulkLetterType');
        Route::put('letter-type/active', 'API\v1\HumanResources\MasterData\LetterTypeController@putLetterTypeActive');
        Route::get('letter-type/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\LetterTypeController@getLetterTypeSlug');
        Route::prefix('letter-type')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\LetterTypeController@postLetterTypeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#other allowance type region">

        /*Route::get('other-allowance-type/list', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@getOtherAllowanceTypeList');
        Route::post('other-allowance-type/list-search', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@postOtherAllowanceTypeListSearch');
        Route::post('other-allowance-type/page-search', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@postOtherAllowanceTypePageSearch');
        Route::get('other-allowance-type/detail/{id}', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@getOtherAllowanceTypeDetail');
        Route::post('other-allowance-type/create', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@postOtherAllowanceTypeCreate');
        Route::put('other-allowance-type/update', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@putOtherAllowanceTypeUpdate');
        Route::delete('other-allowance-type/delete/{id}', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@deleteOtherAllowanceType');
        Route::put('other-allowance-type/active', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@putOtherAllowanceTypeActive');
        Route::get('other-allowance-type/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\OtherAllowanceTypeController@getOtherAllowanceTypeSlug');*/

        //</editor-fold>


        //<editor-fold desc="#other type region">

        Route::get('other-type/list', 'API\v1\HumanResources\MasterData\OtherTypeController@getOtherTypeList');
        Route::post('other-type/list-search', 'API\v1\HumanResources\MasterData\OtherTypeController@postOtherTypeListSearch');
        Route::post('other-type/page-search', 'API\v1\HumanResources\MasterData\OtherTypeController@postOtherTypePageSearch');
        Route::get('other-type/detail/{id}', 'API\v1\HumanResources\MasterData\OtherTypeController@getOtherTypeDetail');
        Route::post('other-type/create', 'API\v1\HumanResources\MasterData\OtherTypeController@postOtherTypeCreate');
        Route::put('other-type/update', 'API\v1\HumanResources\MasterData\OtherTypeController@putOtherTypeUpdate');
        Route::delete('other-type/delete/{id}', 'API\v1\HumanResources\MasterData\OtherTypeController@deleteOtherType');
        Route::delete('other-type/deletes', 'API\v1\HumanResources\MasterData\OtherTypeController@deleteBulkOtherType');
        Route::put('other-type/active', 'API\v1\HumanResources\MasterData\OtherTypeController@putOtherTypeActive');
        Route::get('other-type/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\OtherTypeController@getOtherTypeSlug');
        Route::prefix('other-type')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\OtherTypeController@postOtherTypeListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#position region">

        Route::get('position/list', 'API\v1\HumanResources\MasterData\PositionController@getPositionList');
        Route::get('position/list-hierarchical', 'API\v1\HumanResources\MasterData\PositionController@getPositionListHierarchical');
        Route::post('position/list-search', 'API\v1\HumanResources\MasterData\PositionController@postPositionListSearch');
        Route::post('position/page-search', 'API\v1\HumanResources\MasterData\PositionController@postPositionPageSearch');
        Route::get('position/detail/{id}', 'API\v1\HumanResources\MasterData\PositionController@getPositionDetail');
        Route::post('position/create', 'API\v1\HumanResources\MasterData\PositionController@postPositionCreate');
        Route::put('position/update', 'API\v1\HumanResources\MasterData\PositionController@putPositionUpdate');
        Route::delete('position/delete/{id}', 'API\v1\HumanResources\MasterData\PositionController@deletePosition');
        Route::delete('position/deletes', 'API\v1\HumanResources\MasterData\PositionController@deleteBulkPosition');
        Route::put('position/active', 'API\v1\HumanResources\MasterData\PositionController@putPositionActive');
        Route::get('position/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\PositionController@getPositionSlug');
        Route::prefix('position')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\PositionController@postPositionListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#salary structure region">

        Route::get('salary-structure/list', 'API\v1\HumanResources\MasterData\SalaryStructureController@getSalaryStructureList');
        Route::post('salary-structure/list-search', 'API\v1\HumanResources\MasterData\SalaryStructureController@postSalaryStructureListSearch');
        Route::post('salary-structure/page-search', 'API\v1\HumanResources\MasterData\SalaryStructureController@postSalaryStructurePageSearch');
        Route::get('salary-structure/detail/{id}', 'API\v1\HumanResources\MasterData\SalaryStructureController@getSalaryStructureDetail');
        Route::post('salary-structure/create', 'API\v1\HumanResources\MasterData\SalaryStructureController@postSalaryStructureCreate');
        Route::put('salary-structure/update', 'API\v1\HumanResources\MasterData\SalaryStructureController@putSalaryStructureUpdate');
        Route::delete('salary-structure/delete/{id}', 'API\v1\HumanResources\MasterData\SalaryStructureController@deleteSalaryStructure');
        Route::delete('salary-structure/deletes', 'API\v1\HumanResources\MasterData\SalaryStructureController@deleteBulkSalaryStructure');
        Route::put('salary-structure/active', 'API\v1\HumanResources\MasterData\SalaryStructureController@putSalaryStructureActive');
        Route::get('salary-structure/slug/{company_id}/{name}', 'API\v1\HumanResources\MasterData\SalaryStructureController@getSalaryStructureSlug');
        Route::prefix('salary-structure')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\SalaryStructureController@postSalaryStructureListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#work area region">

        Route::get('work-area/list', 'API\v1\HumanResources\MasterData\WorkAreaController@getWorkAreaList');
        Route::post('work-area/list-search', 'API\v1\HumanResources\MasterData\WorkAreaController@postWorkAreaListSearch');
        Route::post('work-area/page-search', 'API\v1\HumanResources\MasterData\WorkAreaController@postWorkAreaPageSearch');
        Route::get('work-area/detail/{id}', 'API\v1\HumanResources\MasterData\WorkAreaController@getWorkAreaDetail');
        Route::post('work-area/create', 'API\v1\HumanResources\MasterData\WorkAreaController@postWorkAreaCreate');
        Route::put('work-area/update', 'API\v1\HumanResources\MasterData\WorkAreaController@putWorkAreaUpdate');
        Route::delete('work-area/delete/{id}', 'API\v1\HumanResources\MasterData\WorkAreaController@deleteWorkArea');
        Route::delete('work-area/deletes', 'API\v1\HumanResources\MasterData\WorkAreaController@deleteBulkWorkArea');
        Route::put('work-area/active', 'API\v1\HumanResources\MasterData\WorkAreaController@putWorkAreaActive');
        Route::get('work-area/slug/{company_id}/{title}', 'API\v1\HumanResources\MasterData\WorkAreaController@getWorkAreaSlug');
        Route::prefix('work-area')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\WorkAreaController@postWorkAreaListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#work unit region">

        Route::get('work-unit/list', 'API\v1\HumanResources\MasterData\WorkUnitController@getWorkUnitList');
        Route::get('work-unit/list-hierarchical', 'API\v1\HumanResources\MasterData\WorkUnitController@getWorkUnitListHierarchical');
        Route::post('work-unit/list-search', 'API\v1\HumanResources\MasterData\WorkUnitController@postWorkUnitListSearch');
        Route::post('work-unit/page-search', 'API\v1\HumanResources\MasterData\WorkUnitController@postWorkUnitPageSearch');
        Route::get('work-unit/detail/{id}', 'API\v1\HumanResources\MasterData\WorkUnitController@getWorkUnitDetail');
        Route::post('work-unit/create', 'API\v1\HumanResources\MasterData\WorkUnitController@postWorkUnitCreate');
        Route::put('work-unit/update', 'API\v1\HumanResources\MasterData\WorkUnitController@putWorkUnitUpdate');
        Route::delete('work-unit/delete/{id}', 'API\v1\HumanResources\MasterData\WorkUnitController@deleteWorkUnit');
        Route::delete('work-unit/deletes', 'API\v1\HumanResources\MasterData\WorkUnitController@deleteBulkWorkUnit');
        Route::put('work-unit/active', 'API\v1\HumanResources\MasterData\WorkUnitController@putWorkUnitActive');
        Route::get('work-unit/slug/{company_id}/{title}', 'API\v1\HumanResources\MasterData\WorkUnitController@getWorkUnitSlug');
        Route::prefix('work-unit')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\MasterData\WorkAreaController@postWorkAreaListSearchExport');
        });

        //</editor-fold>

        //<editor-fold desc="#additional question region">

        Route::get('additional-questions', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@getAdditionalQuestionList');
        Route::post('additional-questions/list-search', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@postAdditionalQuestionListSearch');
        Route::post('additional-questions/page-search', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@postAdditionalQuestionPageSearch');
        Route::post('additional-question', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@postAdditionalQuestionCreate');
        Route::put('additional-question', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@putAdditionalQuestionUpdate');
        Route::delete('additional-question/{id}', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@deleteAdditionalQuestion');
        Route::delete('additional-questions', 'API\v1\HumanResources\MasterData\AdditionalQuestionController@deleteBulkAdditionalQuestion');

        //</editor-fold>


        //<editor-fold desc="#setting region">

        Route::prefix('setting')->group(function () {
            Route::post('initialize', 'API\v1\SettingController@postSettingInitializeDefault');
            Route::post('initialize/additional', 'API\v1\SettingController@postSettingInitializeAdditional');
            Route::post('initialize/all', 'API\v1\SettingController@postSettingInitializeDefaultAll');
            Route::prefix('initialize')->group(function () {
                Route::post('additional/all', 'API\v1\SettingController@postSettingInitializeAdditionalAll');
            });
        });


        //</editor-fold>

        //<editor-fold desc="#applicant region">

        Route::get('applicant', 'API\v1\HumanResources\Reqruitment\ApplicantController@getApplicantList');
        Route::post('applicant/list-search', 'API\v1\HumanResources\Reqruitment\ApplicantController@postApplicantListSearch');
        Route::post('applicant/page-search', 'API\v1\HumanResources\Reqruitment\ApplicantController@postApplicantPageSearch');
        Route::post('applicant/create', 'API\v1\HumanResources\Reqruitment\ApplicantController@postApplicantCreate');
        Route::get('applicant/{id}', 'API\v1\HumanResources\Reqruitment\ApplicantController@getApplicantDetail');
        Route::put('applicant/update', 'API\v1\HumanResources\Reqruitment\ApplicantController@putApplicantUpdate');
        Route::delete('applicant/{id}', 'API\v1\HumanResources\Reqruitment\ApplicantController@postApplicantDelete');
        Route::get('user/applicant', 'API\v1\HumanResources\Reqruitment\ApplicantController@getApplicantUser');

        //</editor-fold>

        //<editor-fold desc="#vacancy applicant region">

        Route::get('vacancy-applicants', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@getVacancyApplicantList');
        Route::post('vacancy-applicants/list-search', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@postVacancyApplicantListSearch');
        Route::post('vacancy-applicants/page-search', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@postVacancyApplicantPageSearch');
        Route::post('vacancy-applicant', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@postVacancyApplicantCreate');
        Route::put('vacancy-applicant/{id}/status', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@putVacancyApplicantUpdateStatus');
        Route::put('vacancy-applicant/{id}/on-board', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@jobOnBoardVacancyApplicant');
        Route::put('vacancy-applicant/{id}/note', 'API\v1\HumanResources\Reqruitment\VacancyApplicantController@noteVacancyApplicant');

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#payroll region">


        //<editor-fold desc="#payroll balance region">

        Route::get('payroll-balance/list', 'API\v1\HumanResources\Payroll\PayrollBalanceController@getPayrollBalanceList');
        Route::post('payroll-balance/list-search', 'API\v1\HumanResources\Payroll\PayrollBalanceController@postPayrollBalanceListSearch');
        Route::post('payroll-balance/page-search', 'API\v1\HumanResources\Payroll\PayrollBalanceController@postPayrollBalancePageSearch');
        Route::get('payroll-balance/detail/{id}', 'API\v1\HumanResources\Payroll\PayrollBalanceController@getPayrollBalanceDetail');
        Route::post('payroll-balance/create', 'API\v1\HumanResources\Payroll\PayrollBalanceController@postPayrollBalanceCreate');
        Route::put('payroll-balance/update', 'API\v1\HumanResources\Payroll\PayrollBalanceController@putPayrollBalanceUpdate');
        Route::delete('payroll-balance/delete/{id}', 'API\v1\HumanResources\Payroll\PayrollBalanceController@deletePayrollBalance');
        Route::get('payroll-balance/slug/{name}', 'API\v1\HumanResources\Payroll\PayrollBalanceController@getPayrollBalanceSlug');

        //</editor-fold>


        //<editor-fold desc="#payroll batch region">

        /*Route::get('payroll-batch/list', 'API\v1\HumanResources\MasterData\PayrollBatchController@getPayrollBatchList');
        Route::post('payroll-batch/list-search', 'API\v1\HumanResources\MasterData\PayrollBatchController@postPayrollBatchListSearch');
        Route::post('payroll-batch/page-search', 'API\v1\HumanResources\MasterData\PayrollBatchController@postPayrollBatchPageSearch');
        Route::get('payroll-batch/detail/{id}', 'API\v1\HumanResources\MasterData\PayrollBatchController@getPayrollBatchDetail');
        Route::post('payroll-batch/create', 'API\v1\HumanResources\MasterData\PayrollBatchController@postPayrollBatchCreate');
        Route::put('payroll-batch/update', 'API\v1\HumanResources\MasterData\PayrollBatchController@putPayrollBatchUpdate');
        Route::delete('payroll-batch/delete/{id}', 'API\v1\HumanResources\MasterData\PayrollBatchController@deletePayrollBatch');
        Route::get('payroll-batch/slug/{name}', 'API\v1\HumanResources\MasterData\PayrollBatchController@getPayrollBatchSlug');*/

        //</editor-fold>


        //<editor-fold desc="#payroll process type region">

        Route::get('payroll-process-type/list', 'API\v1\Commons\PayrollProcessTypeController@getPayrollProcessTypeList');
        Route::post('payroll-process-type/list-search', 'API\v1\Commons\PayrollProcessTypeController@postPayrollProcessTypeListSearch');
        Route::post('payroll-process-type/page-search', 'API\v1\Commons\PayrollProcessTypeController@postPayrollProcessTypePageSearch');
        Route::get('payroll-process-type/detail/{id}', 'API\v1\Commons\PayrollProcessTypeController@getPayrollProcessTypeDetail');
        Route::post('payroll-process-type/create', 'API\v1\Commons\PayrollProcessTypeController@postPayrollProcessTypeCreate');
        Route::put('payroll-process-type/update', 'API\v1\Commons\PayrollProcessTypeController@putPayrollProcessTypeUpdate');
        Route::delete('payroll-process-type/delete/{id}', 'API\v1\Commons\PayrollProcessTypeController@deletePayrollProcessType');
        Route::delete('payroll-process-type/deletes', 'API\v1\Commons\PayrollProcessTypeController@deleteBulkPayrollProcessType');
        Route::get('payroll-process-type/slug/{applicationId}/{name}', 'API\v1\Commons\PayrollProcessTypeController@getPayrollProcessTypeSlug');

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#personal region">


        //<editor-fold desc="#employee region">

        Route::get('employee/list', 'API\v1\HumanResources\Personal\Employee\EmployeeController@getEmployeeList');
        Route::post('employee/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeListSearch');
        Route::post('employee/page-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeePageSearch');

        Route::get('employee/terminated/list', 'API\v1\HumanResources\Personal\Employee\EmployeeController@getEmployeeTerminatedList');
        Route::post('employee/terminated/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeTerminatedListSearch');
        Route::post('employee/terminated/page-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeTerminatedPageSearch');

        Route::get('employee/birth-day/list', 'API\v1\HumanResources\Personal\Employee\EmployeeController@getEmployeeBirthDayList');
        Route::post('employee/birth-day/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeBirthDayListSearch');
        Route::post('employee/birth-day/page-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeBirthDayPageSearch');

        // New Endpoint
        Route::post('employee/office/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeGroupByOffice');
        Route::post('employee/workArea/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeGroupByWorkArea');
        Route::post('employee/position/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeGroupByPosition');
        Route::post('employee/workUnit/list-search', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeGroupByWorkUnit');

        Route::get('employee/detail/{id}', 'API\v1\HumanResources\Personal\Employee\EmployeeController@getEmployeeDetail');
        Route::post('employee/create', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeCreate');
        Route::put('employee/update', 'API\v1\HumanResources\Personal\Employee\EmployeeController@putEmployeeUpdate');
        Route::delete('employee/delete/{id}', 'API\v1\HumanResources\Personal\Employee\EmployeeController@deleteEmployee');
        Route::delete('employee/deletes', 'API\v1\HumanResources\Personal\Employee\EmployeeController@deleteBulkEmployee');
        Route::prefix('employee')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\EmployeeController@postEmployeeListSearchExport');
        });

        //<editor-fold desc="#child region">

        Route::get('child/list', 'API\v1\HumanResources\Personal\Employee\ChildController@getChildList');
        Route::post('child/list-search', 'API\v1\HumanResources\Personal\Employee\ChildController@postChildListSearch');
        Route::post('child/page-search', 'API\v1\HumanResources\Personal\Employee\ChildController@postChildPageSearch');
        Route::get('child/detail/{id}', 'API\v1\HumanResources\Personal\Employee\ChildController@getChildDetail');
        Route::post('child/create', 'API\v1\HumanResources\Personal\Employee\ChildController@postChildCreate');
        Route::put('child/update', 'API\v1\HumanResources\Personal\Employee\ChildController@putChildUpdate');
        Route::delete('child/delete/{id}', 'API\v1\HumanResources\Personal\Employee\ChildController@deleteChild');
        Route::delete('child/deletes', 'API\v1\HumanResources\Personal\Employee\ChildController@deleteBulkChild');
        Route::prefix('child')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\ChildController@postChildListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#formal education history region">

        Route::get('formal-education-history/list', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@getFormalEducationHistoryList');
        Route::post('formal-education-history/list-search', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@postFormalEducationHistoryListSearch');
        Route::post('formal-education-history/page-search', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@postFormalEducationHistoryPageSearch');
        Route::get('formal-education-history/detail/{id}', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@getFormalEducationHistoryDetail');
        Route::post('formal-education-history/create', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@postFormalEducationHistoryCreate');
        Route::put('formal-education-history/update', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@putFormalEducationHistoryUpdate');
        Route::delete('formal-education-history/delete/{id}', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@deleteFormalEducationHistory');
        Route::delete('formal-education-history/deletes', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@deleteBulkFormalEducationHistory');
        Route::prefix('formal-education-history')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\FormalEducationHistoryController@postFormalEducationHistoryListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#non formal education history region">

        Route::get('non-formal-education-history/list', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@getNonFormalEducationHistoryList');
        Route::post('non-formal-education-history/list-search', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@postNonFormalEducationHistoryListSearch');
        Route::post('non-formal-education-history/page-search', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@postNonFormalEducationHistoryPageSearch');
        Route::get('non-formal-education-history/detail/{id}', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@getNonFormalEducationHistoryDetail');
        Route::post('non-formal-education-history/create', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@postNonFormalEducationHistoryCreate');
        Route::put('non-formal-education-history/update', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@putNonFormalEducationHistoryUpdate');
        Route::delete('non-formal-education-history/delete/{id}', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@deleteNonFormalEducationHistory');
        Route::delete('non-formal-education-history/deletes', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@deleteBulkNonFormalEducationHistory');
        Route::prefix('non-formal-education-history')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\NonFormalEducationHistoryController@postNonFormalEducationHistoryListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#organization history region">

        Route::get('organization-history/list', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@getOrganizationHistoryList');
        Route::post('organization-history/list-search', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@postOrganizationHistoryListSearch');
        Route::post('organization-history/page-search', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@postOrganizationHistoryPageSearch');
        Route::get('organization-history/detail/{id}', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@getOrganizationHistoryDetail');
        Route::post('organization-history/create', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@postOrganizationHistoryCreate');
        Route::put('organization-history/update', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@putOrganizationHistoryUpdate');
        Route::delete('organization-history/delete/{id}', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@deleteOrganizationHistory');
        Route::delete('organization-history/deletes', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@deleteBulkOrganizationHistory');
        Route::prefix('organization-history')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\OrganizationHistoryController@postOrganizationHistoryListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#other equipment region">

        Route::get('other-equipment/list', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@getOtherEquipmentList');
        Route::post('other-equipment/list-search', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@postOtherEquipmentListSearch');
        Route::post('other-equipment/page-search', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@postOtherEquipmentPageSearch');
        Route::get('other-equipment/detail/{id}', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@getOtherEquipmentDetail');
        Route::post('other-equipment/create', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@postOtherEquipmentCreate');
        Route::put('other-equipment/update', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@putOtherEquipmentUpdate');
        Route::delete('other-equipment/delete/{id}', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@deleteOtherEquipment');
        Route::delete('other-equipment/deletes', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@deleteBulkOtherEquipment');
        Route::prefix('other-equipment')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\OtherEquipmentController@postOtherEquipmentListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#work competence region">

        Route::get('work-competence/list', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@getWorkCompetenceList');
        Route::post('work-competence/list-search', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@postWorkCompetenceListSearch');
        Route::post('work-competence/page-search', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@postWorkCompetencePageSearch');
        Route::get('work-competence/detail/{id}', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@getWorkCompetenceDetail');
        Route::post('work-competence/create', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@postWorkCompetenceCreate');
        Route::put('work-competence/update', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@putWorkCompetenceUpdate');
        Route::delete('work-competence/delete/{id}', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@deleteWorkCompetence');
        Route::delete('work-competence/deletes', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@deleteBulkWorkCompetence');
        Route::prefix('work-competence')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\WorkCompetenceController@postWorkCompetenceListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#work experience region">

        Route::get('work-experience/list', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@getWorkExperienceList');
        Route::post('work-experience/list-search', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@postWorkExperienceListSearch');
        Route::post('work-experience/page-search', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@postWorkExperiencePageSearch');
        Route::get('work-experience/detail/{id}', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@getWorkExperienceDetail');
        Route::post('work-experience/create', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@postWorkExperienceCreate');
        Route::put('work-experience/update', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@putWorkExperienceUpdate');
        Route::delete('work-experience/delete/{id}', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@deleteWorkExperience');
        Route::delete('work-experience/deletes', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@deleteBulkWorkExperience');
        Route::prefix('work-experience')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\Employee\WorkExperienceController@postWorkExperienceListSearchExport');
        });

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#position mutation region">

        /*Route::get('position-mutation/list', 'API\v1\HumanResources\Personal\PositionMutationController@getPositionMutationList');
        Route::post('position-mutation/list-search', 'API\v1\HumanResources\Personal\PositionMutationController@postPositionMutationListSearch');
        Route::post('position-mutation', 'API\v1\HumanResources\Personal\PositionMutationController@postWorkPositionMutationPageSearch');
        Route::get('position-mutation/detail/{id}', 'API\v1\HumanResources\Personal\PositionMutationController@getPositionMutationDetail');
        Route::post('position-mutation/create', 'API\v1\HumanResources\Personal\PositionMutationController@postPositionMutationCreate');
        Route::put('position-mutation/update', 'API\v1\HumanResources\Personal\PositionMutationController@putPositionMutationUpdate');
        Route::delete('position-mutation/delete/{id}', 'API\v1\HumanResources\Personal\PositionMutationController@deletePositionMutation');
        Route::delete('position-mutation/deletes', 'API\v1\HumanResources\Personal\PositionMutationController@deleteBulkPositionMutation');
        Route::prefix('position-mutation')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\PositionMutationController@postPositionMutationListSearchExport');
        });*/

        //</editor-fold>


        //<editor-fold desc="#project mutation">

        /*Route::get('project-mutation/list', 'API\v1\HumanResources\Personal\ProjectMutationController@postProjectMutationList');
        Route::post('project-mutation/list-search', 'API\v1\HumanResources\Personal\ProjectMutationController@postProjectMutationListSearch');
        Route::post('project-mutation/page-search', 'API\v1\HumanResources\Personal\ProjectMutationController@postProjectMutationPageSearch');
        Route::get('project-mutation/detail/{id}', 'API\v1\HumanResources\Personal\ProjectMutationController@getProjectMutationDetail');
        Route::post('project-mutation/create', 'API\v1\HumanResources\Personal\ProjectMutationController@postProjectMutationCreate');
        Route::put('project-mutation/update', 'API\v1\HumanResources\Personal\ProjectMutationController@putProjectMutationUpdate');
        Route::delete('project-mutation/delete/{id}', 'API\v1\HumanResources\Personal\ProjectMutationController@deleteProjectMutation');
        Route::delete('project-mutation/deletes', 'API\v1\HumanResources\Personal\ProjectMutationController@deleteBulkProjectMutation');
        Route::prefix('project-mutation')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\ProjectMutationController@postProjectMutationListSearchExport');
        });*/

        //</editor-fold>


        //<editor-fold desc="#registration letter">

        Route::get('registration-letter/list', 'API\v1\HumanResources\Personal\RegistrationLetterController@postRegistrationLetterList');
        Route::post('registration-letter/list-search', 'API\v1\HumanResources\Personal\RegistrationLetterController@postRegistrationLetterListSearch');
        Route::post('registration-letter/page-search', 'API\v1\HumanResources\Personal\RegistrationLetterController@postRegistrationLetterPageSearch');
        Route::get('registration-letter/detail/{id}', 'API\v1\HumanResources\Personal\RegistrationLetterController@getRegistrationLetterDetail');
        Route::post('registration-letter/create', 'API\v1\HumanResources\Personal\RegistrationLetterController@postRegistrationLetterCreate');
        Route::put('registration-letter/update', 'API\v1\HumanResources\Personal\RegistrationLetterController@putRegistrationLetterUpdate');
        Route::delete('registration-letter/delete/{id}', 'API\v1\HumanResources\Personal\RegistrationLetterController@deleteRegistrationLetter');
        Route::delete('registration-letter/deletes', 'API\v1\HumanResources\Personal\RegistrationLetterController@deleteBulkRegistrationLetter');
        Route::prefix('registration-letter')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\RegistrationLetterController@postRegistrationLetterListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#termination">

        Route::get('terminations', 'API\v1\HumanResources\Termination\TerminationController@getTerminationList');
        Route::post('terminations/list-search', 'API\v1\HumanResources\Termination\TerminationController@postTerminationListSearch');
        Route::post('terminations/page-search', 'API\v1\HumanResources\Termination\TerminationController@postTerminationPageSearch');
        Route::post('termination', 'API\v1\HumanResources\Termination\TerminationController@postTerminationCreate');
        Route::put('termination', 'API\v1\HumanResources\Termination\TerminationController@putTerminationUpdate');
        Route::delete('termination/{id}', 'API\v1\HumanResources\Termination\TerminationController@deleteTermination');
        Route::delete('terminations', 'API\v1\HumanResources\Termination\TerminationController@deleteBulkTermination');
        Route::post('terminations/export', 'API\v1\HumanResources\Termination\TerminationController@postTerminationListSearchExport');

        //</editor-fold>


        //<editor-fold desc="#work agreement letter">

        Route::get('work-agreement-letter/list', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@postWorkAgreementLetterList');
        Route::post('work-agreement-letter/list-search', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@postWorkAgreementLetterListSearch');
        Route::post('work-agreement-letter/page-search', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@postWorkAgreementLetterPageSearch');
        Route::get('work-agreement-letter/detail/{id}', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@getWorkAgreementLetterDetail');
        Route::post('work-agreement-letter/create', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@postWorkAgreementLetterCreate');
        Route::put('work-agreement-letter/update', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@putWorkAgreementLetterUpdate');
        Route::delete('work-agreement-letter/delete/{id}', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@deleteWorkAgreementLetter');
        Route::delete('work-agreement-letter/deletes', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@deleteBulkWorkAgreementLetter');
        Route::prefix('work-agreement-letter')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Personal\WorkAgreementLetterController@postWorkAgreementLetterListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#work unit mutation region">

        Route::get('/employee/{id}/work-unit-mutations', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@getWorkUnitMutationList');
        Route::post('/employee/{id}/work-unit-mutation/list-search', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@postWorkUnitMutationListSearch');
        Route::post('/employee/{id}/work-unit-mutation/page-search', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@postWorkUnitMutationPageSearch');
        Route::get('/employee/{id}/work-unit-mutation/{workUnitMutationId}', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@getWorkUnitMutationDetail');
        Route::post('/employee/{id}/work-unit-mutation', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@postWorkUnitMutationCreate');
        Route::put('/employee/{id}/work-unit-mutation', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@putWorkUnitMutationUpdate');
        Route::delete('/employee/{id}/work-unit-mutation/delete/{workUnitMutationId}', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@deleteWorkUnitMutation');
        Route::delete('/employee/{id}/work-unit-mutations', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@deleteBulkWorkUnitMutation');
        Route::post('/employee/{id}/work-unit-mutations/export', 'API\v1\HumanResources\Mutation\WorkUnitMutationController@postWorkUnitMutationListSearchExport');

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#project region">


        Route::get('project/list', 'API\v1\HumanResources\Project\ProjectController@getProjectList');
        Route::get('project/list-hierarchical', 'API\v1\HumanResources\Project\ProjectController@getProjectListHierarchical');
        Route::post('project/list-search', 'API\v1\HumanResources\Project\ProjectController@postProjectListSearch');
        Route::post('project/page-search', 'API\v1\HumanResources\Project\ProjectController@postProjectPageSearch');
        Route::get('project/detail/{id}', 'API\v1\HumanResources\Project\ProjectController@getProjectDetail');
        Route::post('project/create', 'API\v1\HumanResources\Project\ProjectController@postProjectCreate');
        Route::put('project/update', 'API\v1\HumanResources\Project\ProjectController@putProjectUpdate');
        Route::delete('project/delete/{id}', 'API\v1\HumanResources\Project\ProjectController@deleteProject');
        Route::delete('project/deletes', 'API\v1\HumanResources\Project\ProjectController@deleteBulkProject');
        Route::prefix('project')->group(function () {
            Route::post('list-search/export', 'API\v1\HumanResources\Project\ProjectController@postProjectListSearchExport');
        });

        //</editor-fold>


        //<editor-fold desc="#project mutation">

        Route::get('/employee/{id}/project-mutations', 'API\v1\HumanResources\Mutation\ProjectMutationController@getProjectMutationList');
        Route::post('/employee/{id}/project-mutation/list-search', 'API\v1\HumanResources\Mutation\ProjectMutationController@postProjectMutationListSearch');
        Route::post('/employee/{id}/project-mutation/page-search', 'API\v1\HumanResources\Mutation\ProjectMutationController@postProjectMutationPageSearch');
        Route::get('/employee/{id}/project-mutation/{projectMutationId}', 'API\v1\HumanResources\Mutation\ProjectMutationController@getProjectMutationDetail');
        Route::post('/employee/{id}/project-mutation', 'API\v1\HumanResources\Mutation\ProjectMutationController@postProjectMutationCreate');
        Route::put('/employee/{id}/project-mutation', 'API\v1\HumanResources\Mutation\ProjectMutationController@putProjectMutationUpdate');
        Route::delete('/employee/{id}/project-mutation/{mutationId}', 'API\v1\HumanResources\Mutation\ProjectMutationController@deleteProjectMutation');
        Route::delete('/employee/{id}/project-mutations', 'API\v1\HumanResources\Mutation\ProjectMutationController@deleteBulkProjectMutation');
        Route::post('/employee/{id}/project-mutations/export', 'API\v1\HumanResources\Mutation\ProjectMutationController@postProjectMutationListSearchExport');

        //</editor-fold>


        //<editor-fold desc="#position mutation"

        Route::get('/employee/{id}/position-mutations', 'API\v1\HumanResources\Mutation\PositionMutationController@getPositionMutationList');
        Route::post('/employee/{id}/position-mutation/list-search', 'API\v1\HumanResources\Mutation\PositionMutationController@postPositionMutationListSearch');
        Route::post('/employee/{id}/position-mutation/page-search', 'API\v1\HumanResources\Mutation\PositionMutationController@postPositionMutationPageSearch');
        Route::get('/employee/{id}/position-mutation/{positionMutationId}', 'API\v1\HumanResources\Mutation\PositionMutationController@getPositionMutationDetail');
        Route::post('/employee/{id}/position-mutation', 'API\v1\HumanResources\Mutation\PositionMutationController@postPositionMutationCreate');
        Route::put('/employee/{id}/position-mutation', 'API\v1\HumanResources\Mutation\PositionMutationController@putPositionMutationUpdate');
        Route::delete('/employee/{id}/position-mutation/delete/{positionMutationId}', 'API\v1\HumanResources\Mutation\PositionMutationController@deletePositionMutation');
        Route::delete('/employee/{id}/position-mutations', 'API\v1\HumanResources\Mutation\PositionMutationController@deleteBulkPositionMutation');
        Route::post('/employee/{id}/position-mutations/export', 'API\v1\HumanResources\Mutation\PositionMutationController@postPositionMutationListSearchExport');

        //Route::post('/position-mutation/page-search', 'API\v1\HumanResources\Mutation\PositionMutationController@postPositionMutationPageSearchCompany');


        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#media library region">

        Route::get('media/list', 'API\v1\MediaController@getMediaLibraryList');
        Route::post('media/list-search', 'API\v1\MediaController@postMediaLibraryListSearch');
        Route::post('media/page-search', 'API\v1\MediaController@postMediaLibraryPageSearch');
        Route::post('file/upload', 'API\v1\MediaController@postUploadFile');
        Route::get('file/download', 'API\v1\MediaController@getDownloadFile');
        Route::delete('file/delete/{id}', 'API\v1\MediaController@deleteRemoveFile');

        //</editor-fold>


        //<editor-fold desc="#user region">

        Route::get('user/list', 'API\v1\UserController@getUserList');
        Route::post('user/list-search', 'API\v1\UserController@postUserListSearch');
        Route::post('user/page-search', 'API\v1\UserController@postUserPageSearch');
        Route::get('user/detail/{id}', 'API\v1\UserController@getUserDetail');
        Route::prefix('user/detail/{id}')->group(function () {
            Route::get('/company', 'API\v1\UserController@getUserCompany');
            Route::get('/application', 'API\v1\UserController@getUserApplication');
            Route::get('/role', 'API\v1\UserController@getUserRole');
            Route::get('/role/permission', 'API\v1\UserController@getUserRolePermission');
        });
        Route::prefix('user/update')->group(function () {
            Route::put('/password', 'API\v1\UserController@putUserUpdatePassword');
            Route::put('/role', 'API\v1\UserController@putUserUpdateRole');
            Route::put('/permission', 'API\v1\UserController@putUserUpdatePermission');
        });
        Route::delete('user/delete/{id}', 'API\v1\UserController@deleteUser');
        Route::put('user/active', 'API\v1\UserController@putUserActive');
        Route::put('user/block', 'API\v1\UserController@putUserBlock');


        //<editor-fold desc="#profile region">

        Route::get('profile/detail/{id}', 'API\v1\ProfileController@getProfileDetail');
        Route::post('profile/create', 'API\v1\ProfileController@postProfileCreate');
        Route::put('profile/update', 'API\v1\ProfileController@putProfileUpdate');
        Route::delete('profile/delete/{id}', 'API\v1\ProfileController@postProfileDelete');
        Route::get('profile/user', 'API\v1\ProfileController@getProfileUser');

        //</editor-fold>


        //</editor-fold>


        //<editor-fold desc="#demo employee region">

        Route::prefix('demo')->group(function () {
            Route::post('employee/page-search', 'API\v1\Demo\DemoController@postEmployeePageSearch');

            Route::get('employee/{id}', 'API\v1\Demo\DemoController@getEmployee');
            Route::post('employee', 'API\v1\Demo\DemoController@postEmployee');
            Route::put('employee/{id}', 'API\v1\Demo\DemoController@putEmployee');
            Route::delete('employee/{id}', 'API\v1\Demo\DemoController@deleteEmployee');
        });

        //</editor-fold>
    });
});
