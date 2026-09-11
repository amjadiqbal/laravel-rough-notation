# Changelog

All notable changes to `laravel-rough-notation` are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-09-11

First tagged release. The package had been on Packagist since February 2026 without a
version tag; this release formalizes what was already shipping as 1.0.

### Added
- `@annotate` / `@endannotate` Blade directives and an `<x-annotate>` Blade component for
  wrapping content in a [Rough Notation](https://roughnotation.com) hand-drawn annotation
  (underline, box, circle, highlight, strike-through, crossed-off, bracket).
- `@roughNotationScripts` directive that outputs the ES module `<script>` block wiring up
  Rough Notation on page load, including automatic re-initialization on Livewire's
  `message.processed` hook.
- Grouped annotations via `data-rough-group`, animated together with `annotationGroup()`.
- `NotationManager` for building the underlying HTML attributes, and a fluent
  `NotationBuilder` / `NotationGroup` API.
- `rough-notation:install` and `rough-notation:publish-assets` Artisan commands.
- CDN or local asset delivery of the Rough Notation JS module, configurable via
  `config/rough-notation.php`.

### Fixed
- `NotationManager::openTag()` used `htmlspecialchars($json, ENT_QUOTES)` to escape the
  `data-rough-options` attribute value, which is single-quote delimited
  (`data-rough-options='...'`). That escaped every `"` in the JSON to `&quot;` as well as the
  single-quote delimiter. Browsers decode that back to `"` transparently when the attribute is
  read via `getAttribute()`/`.dataset`, so this wasn't visibly broken in a browser — but the raw
  attribute value was no longer valid JSON for anything that reads it literally. Now only the
  delimiter itself is escaped.
- `@roughNotationScripts` had a genuine PHP parse error: the generated `<script>` block is built
  as one single-quoted PHP string, and one embedded JS line —
  `window.Livewire.hook('message.processed', ...)` — used an unescaped single quote, which
  closed the PHP string early. Any Blade view using `@roughNotationScripts` failed to compile
  with a `ParseError` at runtime. Switched that JS string to double quotes.

  Both bugs were caught by the package's own Pest suite (`composer test`), which appears not to
  have been run since it was written — this release is the first time all 5 tests pass.
