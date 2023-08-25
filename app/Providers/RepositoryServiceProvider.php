<?php

namespace App\Providers;

use App\Models\Item;
use App\Repositories\AssetRepositoryInterface;
use App\Repositories\BankHolidayRepositoryInterface;
use App\Repositories\Eloquent\WhatWindscreenApiRepository;
use App\Repositories\VehicleHistoryRepositoryInterface;
use App\Repositories\CarMakeRepositoryInterface;
use App\Repositories\CarModelRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryTypeRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\CourtesyCarRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\Eloquent\AssetRepository;
use App\Repositories\Eloquent\BankHolidayRepository;
use App\Repositories\Eloquent\VehicleHistoryRepository;
use App\Repositories\Eloquent\CarMakeRepository;
use App\Repositories\Eloquent\CarModelRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CategoryTypeRepository;
use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Eloquent\CourtesyCarRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\GlassSupplierRepository;
use App\Repositories\Eloquent\GroupMailRepository;
use App\Repositories\Eloquent\GroupRepository;
use App\Repositories\Eloquent\HolidayRepository;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\JobCardItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\SentRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Eloquent\StaffRepository;
use App\Repositories\Eloquent\SubContractorRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\VehicleHistoryDocsRepository;
use App\Repositories\Eloquent\VehicleHistoryInvoiceRepository;
use App\Repositories\Eloquent\VehicleMaintenanceEventRepository;
use App\Repositories\Eloquent\VehicleMaintenanceRepository;
use App\Repositories\Eloquent\VehicleRepository;
use App\Repositories\GlassSupplierRepositoryInterface;
use App\Repositories\GroupMailRepositoryInterface;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\HolidayRepositoryInterface;
use App\Repositories\ItemRepositoryInterface;
use App\Repositories\JobCardItemRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\SentRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use App\Repositories\StaffRepositoryInterface;
use App\Repositories\SubContractorRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VehicleHistoryDocsRepositoryInterface;
use App\Repositories\VehicleHistoryInvoiceRepositoryInterface;
use App\Repositories\VehicleMaintenanceEventRepositoryInterface;
use App\Repositories\VehicleMaintenanceRepositoryInterface;
use App\Repositories\VehicleRepositoryInterface;
use App\Repositories\WhatWindscreenApiRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VehicleHistoryRepositoryInterface::class, VehicleHistoryRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(GlassSupplierRepositoryInterface::class, GlassSupplierRepository::class);
        $this->app->bind(SubContractorRepositoryInterface::class, SubContractorRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(CarMakeRepositoryInterface::class, CarMakeRepository::class);
        $this->app->bind(CarModelRepositoryInterface::class, CarModelRepository::class);
        $this->app->bind(VehicleMaintenanceRepositoryInterface::class, VehicleMaintenanceRepository::class);
        $this->app->bind(VehicleMaintenanceEventRepositoryInterface::class, VehicleMaintenanceEventRepository::class);
        $this->app->bind(GroupMailRepositoryInterface::class, GroupMailRepository::class);
        $this->app->bind(CourtesyCarRepositoryInterface::class, CourtesyCarRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(SentRepositoryInterface::class, SentRepository::class);
        $this->app->bind(BankHolidayRepositoryInterface::class, BankHolidayRepository::class);
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(VehicleHistoryInvoiceRepositoryInterface::class, VehicleHistoryInvoiceRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(JobCardItemRepositoryInterface::class, JobCardItemRepository::class);
        $this->app->bind(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryTypeRepositoryInterface::class, CategoryTypeRepository::class);
        $this->app->bind(VehicleHistoryDocsRepositoryInterface::class, VehicleHistoryDocsRepository::class);
        $this->app->bind(WhatWindscreenApiRepositoryInterface::class, WhatWindscreenApiRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
