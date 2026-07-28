<?php

namespace Themicly\Shopcrafty\Compare\Livewire;

use Livewire\Component;
use Themicly\Shopcrafty\Compare\Services\CompareService;

final class ComparePage extends Component
{
    public function remove(int $productId): void
    {
        app(CompareService::class)->toggle($productId);
    }

    public function clear(): void
    {
        app(CompareService::class)->clear();
    }

    public function render()
    {
        return view('compare::livewire.compare-page', ['products' => app(CompareService::class)->products()]);
    }
}
