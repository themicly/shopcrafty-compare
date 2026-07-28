<?php

namespace Themicly\Shopcrafty\Compare\Services;

use Illuminate\Support\Facades\Session;
use Themicly\Shopcrafty\Modules\Catalog\Models\Product;

final class CompareService
{
    public const MAX = 4;

    private const SESSION_KEY = 'shopcrafty.compare';

    /** @return array<int, int> */
    public function ids(): array
    {
        return array_values(array_map('intval', (array) Session::get(self::SESSION_KEY, [])));
    }

    public function count(): int
    {
        return count($this->ids());
    }

    public function has(int $productId): bool
    {
        return in_array($productId, $this->ids(), true);
    }

    /** @return array{active: bool, count: int, full: bool, max: int} */
    public function toggle(int $productId): array
    {
        $ids = $this->ids();
        $active = in_array($productId, $ids, true);

        if ($active) {
            $ids = array_values(array_diff($ids, [$productId]));
        } elseif (count($ids) < self::MAX) {
            Product::active()->whereKey($productId)->exists() && $ids[] = $productId;
        }

        Session::put(self::SESSION_KEY, $ids);

        return ['active' => in_array($productId, $ids, true), 'count' => count($ids), 'full' => ! $active && count($ids) >= self::MAX, 'max' => self::MAX];
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function products()
    {
        return Product::active()->whereIn('id', $this->ids())->with(['media', 'brand', 'category', 'variants'])->get()->sortBy(fn (Product $product) => array_search($product->id, $this->ids(), true))->values();
    }
}
