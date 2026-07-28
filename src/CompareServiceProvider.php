<?php

namespace Themicly\Shopcrafty\Compare;

use Themicly\Shopcrafty\Core\Module\ModuleServiceProvider;
use Themicly\Shopcrafty\Compare\Services\CompareService;

final class CompareServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string
    {
        return 'Compare';
    }

    protected function modulePath(): string
    {
        return __DIR__;
    }

    protected function bootModule(): void
    {
        $this->addonRegistry()->register('compare', [
            'name' => 'Product compare',
            'description' => 'Let shoppers compare products side by side.',
            'settings_route' => 'admin.themes.settings',
            'provider' => self::class,
            'service' => CompareService::class,
        ]);
        $this->addonRegistry()->registerStorefrontFeature('header', 'compare', [
            'label' => 'Compare',
            'route' => 'storefront.compare',
        ]);
        $this->addonRegistry()->registerSettingsSchema('compare', [
            'label' => 'Compare settings',
            'fields' => ['catalog.compare_enabled'],
        ]);
    }
}
