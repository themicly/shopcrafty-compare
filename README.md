# Shopcrafty Compare

Session-backed product comparison for Shopcrafty. The comparison list works for
guests and signed-in customers and is limited to four active products.

## Requirements

- PHP 8.3+
- Laravel 13+
- `themicly/shopcrafty` 1.0+

## Installation

Install Shopcrafty first, then add the package:

```bash
composer require themicly/shopcrafty-compare
php artisan migrate
```

Enable comparison in Admin → Themes → Storefront settings. The package is
auto-discovered by Laravel and registers its routes, Livewire component, and
addon metadata automatically.

## What it provides

- Storefront comparison page at `/compare`
- JSON toggle endpoint at `/compare/toggle`
- `compare.compare-page` Livewire component
- `CompareService` with `MAX = 4`
- `compare` addon and settings metadata for Shopcrafty themes

The list is stored in the visitor session and is not persisted to the customer
account.

## Theme integration

Addon-owned views use the `compare::` namespace. Shopcrafty’s bundled themes
only render compare links and components when the addon is installed and the
feature is enabled.

## License

MIT. Targets PHP 8.3+ and Laravel 13+.
