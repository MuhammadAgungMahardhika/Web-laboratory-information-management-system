<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CityResource;
use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\CustomerTypeResource;
use App\Filament\Resources\LabJobResource;
use App\Filament\Resources\ParameterResource;
use App\Filament\Resources\PersonelResource;
use App\Filament\Resources\ProvinceResource;
use App\Filament\Resources\QuotationResource;
use App\Filament\Resources\RegulationResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\SampleMatricResource;
use App\Filament\Resources\SampleTypeResource;
use App\Filament\Resources\TermTemplateResource;
use App\Filament\Resources\TestMethodResource;
use App\Filament\Resources\TestPackageResource;
use App\Filament\Resources\UserResource;
use Filament\Resources\Resource;
use Filament\Widgets\Widget;
use App\Filament\Resources\CustomerResource\Widgets\CustomerStatsChart;
use App\Filament\Widgets\DynamicQuotationStatusChart;
use App\Filament\Resources\ParameterResource\Widgets\ParameterAccreditationChart;
use App\Filament\Resources\PersonelResource\Widgets\PersonnelRolesChart;
use App\Filament\Resources\ParameterResource\Widgets\TopParametersTable;
use App\Filament\Resources\TestPackageResource\Widgets\TopTestPackagesTable;

class ResourcesRegistry
{
    /**
     * @return array<class-string<Resource>>
     */
    public static function getSuperAdminResources(): array
    {
        return [
            UserResource::class,
            TestPackageResource::class,
            TestMethodResource::class,
            TermTemplateResource::class,
            SampleTypeResource::class,
            SampleMatricResource::class,
            RoleResource::class,
            RegulationResource::class,
            QuotationResource::class,
            ProvinceResource::class,
            PersonelResource::class,
            ParameterResource::class,
            LabJobResource::class,
            CustomerTypeResource::class,
            CustomerResource::class,
            CompanyResource::class,
            CityResource::class
        ];
    }

    public static function getSuperAdminWidgets(): array
    {
        return [
            TopTestPackagesTable::class,
            TopParametersTable::class,
            ParameterAccreditationChart::class,
            PersonnelRolesChart::class,
            CustomerStatsChart::class,
        ];
    }

    /**
     * @return array<class-string<Resource>>
     */
    public static function getAllResources(): array
    {
        return array_merge(
            static::getSuperAdminResources(),
        );
    }

    /**
     * @return array<class-string<Widget>>
     */
    public static function getAllWidgets(): array
    {
        return array_merge(
            static::getSuperAdminWidgets(),
        );
    }
}
