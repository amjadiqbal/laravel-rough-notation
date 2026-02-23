<p align="center">
  <img src="https://via.placeholder.com/1280x640.png?text=Laravel+Rough+Notation" alt="Laravel Rough Notation Banner" width="100%" />
</p>

<p align="center">
  <a href="https://packagist.org/packages/amjadiqbal/laravel-rough-notation"><img alt="Packagist Version" src="https://img.shields.io/packagist/v/amjadiqbal/laravel-rough-notation.svg?style=flat-square"></a>
  <a href="LICENSE"><img alt="License" src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square"></a>
  <img alt="Build" src="https://img.shields.io/badge/build-passing-brightgreen.svg?style=flat-square">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-%5E8.1-blue?style=flat-square">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-11-red?style=flat-square">
  <a href="https://packagist.org/packages/amjadiqbal/laravel-rough-notation"><img alt="Downloads" src="https://img.shields.io/packagist/dt/amjadiqbal/laravel-rough-notation?style=flat-square"></a>
  <a href="https://github.com/amjadiqbal/laravel-rough-notation/actions"><img alt="CI" src="https://img.shields.io/badge/CI-GitHub%20Actions-informational?style=flat-square"></a>
  <a href="https://github.com/amjadiqbal/laravel-rough-notation/stargazers"><img alt="Stars" src="https://img.shields.io/github/stars/amjadiqbal/laravel-rough-notation?style=flat-square"></a>
  <a href="https://github.com/amjadiqbal/laravel-rough-notation/issues"><img alt="Issues" src="https://img.shields.io/github/issues/amjadiqbal/laravel-rough-notation?style=flat-square"></a>
</p>

# Laravel Rough Notation

Beautiful hand-drawn animations for Laravel. A lightweight Rough Notation wrapper to circle, underline, and highlight elements in your Blade and Livewire applications.

## Features

- Fluent `Notation::` builder for creating annotations
- Blade directives: `@annotate`, `@endannotate`, and `@roughNotationScripts`
- Supports types: underline, box, circle, highlight, strike-through, crossed-off, bracket
- Options: color, strokeWidth, padding, iterations, brackets, animationDuration
- Group multiple annotations to animate in sequence

## Installation

```bash
composer require amjadiqbal/laravel-rough-notation
```

### Interactive Install

Run the guided installer:

```bash
php artisan rough:install
```

Options:

- --cdn=true|false to select CDN vs local
- --publish-assets=true|false to download local ESM script
- --assets-path=public/vendor/rough-notation to pick destination path
- --open-link=true to open support/contact page

Example:

```bash
php artisan rough:install --cdn=false --publish-assets=true --assets-path=public/vendor/rough-notation
```

## Setup

Add scripts to your layout:

```blade
@roughNotationScripts
```

Configuration (optional) published to config/rough-notation.php:

```php
return [
    'assets' => [
        'cdn' => true,
        'module_url' => 'https://unpkg.com/rough-notation?module',
        'local' => [
            'public_url' => '/vendor/rough-notation',
            'module' => 'rough-notation.esm.js',
        ],
    ],
];
```

## Usage

Wrap any text or element:

```blade
@annotate('circle', ['color' => '#ff0055']) Important Text @endannotate
```

With options:

```blade
@annotate('highlight', ['color' => '#fff59d', 'padding' => 6]) Highlighted @endannotate
```

Groups:

```blade
@annotate('underline', [], 'hero') First @endannotate
@annotate('box', ['padding' => 8], 'hero') Second @endannotate
@annotate('circle', ['color' => 'red'], 'hero') Third @endannotate
```

### Chainable API (Non-Blade)

```php
use AmjadIqbal\RoughNotation\Notation;

echo Notation::make('circle')
    ->color('red')
    ->strokeWidth(3)
    ->group('hero')
    ->render('Important Text');
```

## Types Gallery

Each example shows the directive and a short description.

- underline:
  ```blade
  @annotate('underline') Underline @endannotate
  ```
- box:
  ```blade
  @annotate('box', ['padding' => 8]) Boxed @endannotate
  ```
- circle:
  ```blade
  @annotate('circle', ['color' => 'red']) Circled @endannotate
  ```
- highlight:
  ```blade
  @annotate('highlight', ['color' => '#fff59d']) Highlighted @endannotate
  ```
- strike-through:
  ```blade
  @annotate('strike-through') Struck @endannotate
  ```
- crossed-off:
  ```blade
  @annotate('crossed-off') Crossed @endannotate
  ```
- bracket:
  ```blade
  @annotate('bracket', ['brackets' => ['left', 'right']]) Bracketed @endannotate
  ```

## Testing

```bash
vendor/bin/pest
```

## Examples

- Livewire: call `window.initRoughNotation()` after component updates to re-init annotations on dynamic content.
- Multiple groups: mix sequences by assigning different group ids to elements.
- Local assets: after `php artisan rough:publish-assets`, set `cdn` to `false` in config to import the local ESM.

## Contributing

- Follow PSR-12 code style
- Run tests before submitting changes
- Open a PR with a clear description

## License

MIT License. See [LICENSE](LICENSE).
