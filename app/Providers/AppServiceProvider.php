<?php

namespace App\Providers;

use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\LogoutResponse;
use App\Models\TestResult;
use App\Observers\TestResultObserver;
use Filament\Tables\Enums\PaginationMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Enums\RecordActionsPosition;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
        $this->app->bind(\Filament\Auth\Http\Responses\Contracts\LogoutResponse::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Model::unguard();
        Table::configureUsing(fn(Table $table) => $table
            ->recordActions([], position: RecordActionsPosition::BeforeColumns)
            ->modifyUngroupedRecordActionsUsing(fn(Action $action) => $action->iconButton())
            ->striped()
            ->paginationMode(PaginationMode::Simple)
            ->deferFilters(false));
    }
}
