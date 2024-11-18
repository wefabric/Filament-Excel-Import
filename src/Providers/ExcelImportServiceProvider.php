<?php

namespace Wefabric\FilamentExcelImport\Providers;

use Illuminate\Support\ServiceProvider;

class ExcelImportServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/excel.php' => config_path('excel.php'),
        ], 'excel-import-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'excel-import-migrations');
    }
}
