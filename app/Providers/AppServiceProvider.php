<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;

class AppServiceProvider extends ServiceProvider
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
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

        // Register twMerge macro used by BlatUI components.
        // Merges the given class string with any existing class attributes.
        ComponentAttributeBag::macro('twMerge', function (string $classes = '') {
            /** @var ComponentAttributeBag $this */
            $existing = $this->get('class', '');
            $merged   = trim($classes . ' ' . $existing);
            return $this->except('class')->merge(['class' => $merged]);
        });
    }
}

