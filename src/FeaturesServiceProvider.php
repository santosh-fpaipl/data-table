<?php

namespace Fpaipl\Features;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Fpaipl\Features\Http\Livewire\Datatables;
use Fpaipl\Features\Http\Livewire\Delete;
use Fpaipl\Features\Http\Livewire\AppToast;
use Fpaipl\Features\Http\Livewire\AlertBox;
use Fpaipl\Features\View\Components\BulkSelect;
use Fpaipl\Features\View\Components\SelectedRecordsAlertBox;
use Fpaipl\Features\View\Components\DependentModel;
use Fpaipl\Features\Datatables\ModelDatatable;

/*
Calling way  in main app:

1. Livewire Component
@livewire('app-toast')
2. Blade Component
<x-features::alert-box />
3. Blade View
@include('features::test')

*/

class FeaturesServiceProvider extends ServiceProvider {

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
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'features');
        $this->loadViewComponentsAs('features', [
            BulkSelect::class,
            SelectedRecordsAlertBox::class,
            DependentModel::class,
        ]);
        Livewire::component('app-toast', AppToast::class);
        Livewire::component('alert-box', AlertBox::class);
        Livewire::component('datatables', Datatables::class);
        Livewire::component('delete', Delete::class);
    }

    public function provides(): array
    {
        return [
            ModelDatatable::class
        ];
    }

}
