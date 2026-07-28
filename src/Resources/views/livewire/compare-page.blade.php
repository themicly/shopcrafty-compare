<div>
    @if ($products->isEmpty())
        <div class="border p-12 text-center" style="border-color: var(--st-line); border-radius: var(--st-radius)">
            <p class="st-display text-xl" style="color: var(--st-ink)">{{ __('storefront.no_products_compare') }}</p>
            <a href="{{ url('/shop') }}" class="mt-4 inline-flex text-sm font-medium" style="color: var(--st-accent)">{{ __('storefront.browse_the_shop') }}</a>
        </div>
    @else
        <div class="mb-4 flex items-center justify-between"><p class="text-sm" style="color: var(--st-ink-soft)">{{ __('storefront.comparing_count', ['count' => $products->count(), 'max' => \Themicly\Shopcrafty\Compare\Services\CompareService::MAX]) }}</p><button wire:click="clear" class="text-xs font-semibold" style="color: var(--st-ink-soft)">{{ __('storefront.clear_all') }}</button></div>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach ($products as $product)
                <article wire:key="compare-{{ $product->id }}" class="border p-4" style="border-color: var(--st-line); border-radius: var(--st-radius)">
                    <button wire:click="remove({{ $product->id }})" class="float-right text-xs" style="color: var(--st-ink-soft)">{{ __('storefront.remove') }}</button>
                    <a href="{{ url('/product/'.$product->slug) }}"><div class="aspect-square overflow-hidden" style="background: var(--st-surface); border-radius: var(--st-radius)">@if ($product->media->first())<img src="{{ $product->media->first()->path }}" alt="{{ $product->name }}" class="h-full w-full object-cover">@endif</div><h2 class="mt-3 text-sm font-semibold" style="color: var(--st-ink)">{{ $product->name }}</h2></a>
                    <div class="mt-2"><x-st.price :price="$product->price" :compare-at="$product->compare_at_price" size="sm" /></div>
                    <dl class="mt-3 space-y-1 text-xs" style="color: var(--st-ink-soft)"><div><dt class="inline font-semibold">{{ __('storefront.brand') }}:</dt> {{ $product->brand?->name ?? '—' }}</div><div><dt class="inline font-semibold">{{ __('storefront.sku') }}:</dt> {{ $product->sku ?: '—' }}</div><div><dt class="inline font-semibold">{{ __('storefront.availability') }}:</dt> {{ $product->track_inventory && $product->stock_qty <= 0 ? __('storefront.out_of_stock') : __('storefront.in_stock') }}</div></dl>
                </article>
            @endforeach
        </div>
    @endif
</div>
