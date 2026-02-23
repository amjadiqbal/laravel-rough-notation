<?php

namespace AmjadIqbal\RoughNotation;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use AmjadIqbal\RoughNotation\Console\InstallCommand;
use AmjadIqbal\RoughNotation\Console\PublishAssetsCommand;
use AmjadIqbal\RoughNotation\View\Components\Annotate;

class NotationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/rough-notation.php' => config_path('rough-notation.php'),
        ], 'rough-notation-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'rough-notation');
        Blade::component(Annotate::class, 'annotate');
        Blade::anonymousComponentPath(__DIR__ . '/../resources/views/components/annotate', 'rough-notation');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                PublishAssetsCommand::class,
            ]);
        }

        Blade::directive('annotate', function ($expression) {
            return "<?php echo \\AmjadIqbal\\RoughNotation\\Notation::open($expression); ?>";
        });

        Blade::directive('endannotate', function () {
            return "<?php echo \\AmjadIqbal\\RoughNotation\\Notation::close(); ?>";
        });

        Blade::directive('roughNotationScripts', function () {
            return "<?php "
                . "\$cdn = config('rough-notation.assets.cdn', true);"
                . "\$moduleUrl = \$cdn ? config('rough-notation.assets.module_url', 'https://unpkg.com/rough-notation?module') : asset(trim(config('rough-notation.assets.local.public_url', '/vendor/rough-notation'), '/') . '/' . config('rough-notation.assets.local.module', 'rough-notation.esm.js'));"
                . "echo '<script type=\"module\">"
                . "import { annotate, annotationGroup } from \"' . \$moduleUrl . '\";"
                . "window.__RoughNotation__ = { annotate, annotationGroup };"
                . "function initRoughNotation(){"
                . "const elements = document.querySelectorAll(\"[data-rough-type]\");"
                . "const groups = {};"
                . "elements.forEach(el => {"
                . "const type = el.getAttribute(\"data-rough-type\");"
                . "const optionsAttr = el.getAttribute(\"data-rough-options\");"
                . "let opts = {};"
                . "try { opts = optionsAttr ? JSON.parse(optionsAttr) : {}; } catch (e) { opts = {}; }"
                . "const ann = annotate(el, Object.assign({ type }, opts));"
                . "const groupId = el.getAttribute(\"data-rough-group\");"
                . "if (groupId){ if(!groups[groupId]) groups[groupId] = []; groups[groupId].push(ann); } else { ann.show(); }"
                . "});"
                . "Object.keys(groups).forEach(id => { const ag = annotationGroup(groups[id]); ag.show(); });"
                . "}"
                . "window.initRoughNotation = initRoughNotation;"
                . "document.addEventListener(\"DOMContentLoaded\", initRoughNotation);"
                . "if (window.Livewire && window.Livewire.hook) {"
                . "window.Livewire.hook('message.processed', () => { initRoughNotation(); });"
                . "}"
                . "</script>';"
                . " ?>";
        });
    }
}
