<?php

namespace Themicly\Shopcrafty\Compare\Tests\Feature;

use Themicly\Shopcrafty\Compare\Services\CompareService;
use Themicly\Shopcrafty\Compare\Tests\TestCase;
use Themicly\Shopcrafty\Core\Module\AddonRegistry;
use Themicly\Shopcrafty\Modules\Catalog\Models\Product;

final class CompareServiceTest extends TestCase
{
    public function test_addon_registers_its_service_and_routes(): void
    {
        $this->assertSame(CompareService::class, app(AddonRegistry::class)->all()['compare']['service'] ?? null);
        $this->assertTrue(route('storefront.compare') !== '');
        $this->assertTrue(route('storefront.compare.toggle') !== '');
    }

    public function test_toggle_is_session_backed_and_capped_at_four_products(): void
    {
        $this->artisan('migrate');
        $products = collect(range(1, 5))->map(fn (int $id) => Product::create(['name' => "Product {$id}", 'price' => 100, 'status' => 'active']));
        $compare = app(CompareService::class);

        foreach ($products->take(4) as $product) {
            $this->assertTrue($compare->toggle($product->id)['active']);
        }

        $fifth = $compare->toggle($products->last()->id);
        $this->assertTrue($fifth['full']);
        $this->assertSame(4, $compare->count());

        $compare->toggle($products->first()->id);
        $this->assertSame(3, $compare->count());
    }
}
