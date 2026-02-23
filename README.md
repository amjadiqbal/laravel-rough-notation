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
  <img alt="Code Style" src="https://img.shields.io/badge/code%20style-PSR--12-informational?style=flat-square">
  <img alt="SemVer" src="https://img.shields.io/badge/versioning-SemVer-success?style=flat-square">
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

### Publish Config and Assets

Publish the package config:

```bash
php artisan vendor:publish --tag=rough-notation-config
```

Publish local ESM script:

```bash
php artisan rough:publish-assets --path=public/vendor/rough-notation
```

## Quick Start

- Install: `composer require amjadiqbal/laravel-rough-notation`
- Guided install: `php artisan rough:install`
- Publish config: `php artisan vendor:publish --tag=rough-notation-config`
- Publish local ESM: `php artisan rough:publish-assets --path=public/vendor/rough-notation`
- Add scripts: `@roughNotationScripts`
- Annotate with directives, components, or the builder API

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

### Requirements

- PHP 8.1+
- Laravel 11

## Example Layout

```blade
<!-- resources/views/layouts/app.blade.php -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rough Notation Demo</title>
</head>
<body>
  @yield('content')
  @roughNotationScripts
</body>
</html>
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

### Blade Component

Basic component:

```blade
<x-annotate type="circle" :options="['color' => 'red']">Important</x-annotate>
```

Typed components (namespaced):

```blade
<x-rough-notation::circle :options="['color' => 'red']">Circled</x-rough-notation::circle>
<x-rough-notation::underline>Underlined</x-rough-notation::underline>
<x-rough-notation::box :options="['padding' => 8]">Boxed</x-rough-notation::box>
<x-rough-notation::highlight :options="['color' => '#fff59d']">Highlighted</x-rough-notation::highlight>
<x-rough-notation::strike-through>Struck</x-rough-notation::strike-through>
<x-rough-notation::crossed-off>Crossed</x-rough-notation::crossed-off>
<x-rough-notation::bracket :options="['brackets' => ['left','right']]">Bracketed</x-rough-notation::bracket>
```

Props:
- options: array of supported options
- group: string group id to sequence annotations
- tag: wrapper tag (defaults to span)

## Demo Page

```php
// routes/web.php
use Illuminate\Support\Facades\Route;
Route::view('/rough-demo', 'rough-demo');
```

```blade
<!-- resources/views/rough-demo.blade.php -->
@extends('layouts.app')

@section('content')
  <div style="display:grid; gap:16px; padding:24px;">
    @annotate('underline') Underline @endannotate
    @annotate('box', ['padding' => 8]) Boxed @endannotate
    @annotate('circle', ['color' => 'red']) Circled @endannotate
    @annotate('highlight', ['color' => '#fff59d']) Highlighted @endannotate
    @annotate('strike-through') Struck @endannotate
    @annotate('crossed-off') Crossed @endannotate
    @annotate('bracket', ['brackets' => ['left','right']]) Bracketed @endannotate
    @annotate('underline', [], 'hero') Step 1 @endannotate
    @annotate('box', ['padding' => 8], 'hero') Step 2 @endannotate
    @annotate('circle', ['color' => 'red'], 'hero') Step 3 @endannotate
  </div>
@endsection
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

## Livewire Usage

- The scripts directive auto re-initializes after Livewire updates.
- For manual re-init:

```js
window.initRoughNotation();
```

## Testing

```bash
vendor/bin/pest
```

## Examples

- Livewire: call `window.initRoughNotation()` after component updates to re-init annotations on dynamic content.
- Multiple groups: mix sequences by assigning different group ids to elements.
- Local assets: after `php artisan rough:publish-assets`, set `cdn` to `false` in config to import the local ESM.

## Options Reference

- color: string color or hex
- strokeWidth: int line width
- padding: int inner padding in px
- iterations: int number of sketch strokes
- animationDuration: int in ms
- brackets: array|string (left|right|top|bottom) only for type=bracket

## Screenshots

<p align="center">
  <img src="https://via.placeholder.com/800x200.png?text=Underline+Example" alt="Underline Example" />
  <img src="https://via.placeholder.com/800x200.png?text=Box+Example" alt="Box Example" />
  <img src="https://via.placeholder.com/800x200.png?text=Circle+Example" alt="Circle Example" />
  <img src="https://via.placeholder.com/800x200.png?text=Highlight+Example" alt="Highlight Example" />
</p>

## Contributing

- Follow PSR-12 code style
- Run tests before submitting changes
- Open a PR with a clear description

## License

MIT License. See [LICENSE](LICENSE).
