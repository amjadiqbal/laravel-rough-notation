<?php

namespace AmjadIqbal\RoughNotation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'rough:install
        {--cdn= : Use CDN (true/false)}
        {--publish-assets= : Publish assets locally (true/false)}
        {--assets-path= : Local assets path}
        {--open-link= : Open contact page (true/false)}
        {--contact-url= : Contact URL}';

    protected $description = 'Interactive installation for Laravel Rough Notation';

    public function handle()
    {
        $this->line('Thanks for installing Laravel Rough Notation by Amjad Iqbal.');
        $openOpt = $this->option('open-link');
        $link = $this->option('contact-url') ?: 'https://github.com/amjadiqbal/laravel-rough-notation/issues';
        $this->line('If you need help, contact: ' . $link);
        $open = $openOpt !== null ? (filter_var($openOpt, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false) : $this->confirm('Open the contact page now?', false);
        if ($open) {
            $this->openUrl($link);
            $this->info('Opening: ' . $link);
        }

        $cdnOpt = $this->option('cdn');
        if ($cdnOpt === null) {
            $cdn = $this->choice('Use CDN for Rough Notation assets?', ['yes', 'no'], 0) === 'yes';
        } else {
            $cdn = filter_var($cdnOpt, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
        }

        $publishOpt = $this->option('publish-assets');
        if ($publishOpt === null) {
            $publishAssets = $this->choice('Publish local assets?', ['yes', 'no'], $cdn ? 1 : 0) === 'yes';
        } else {
            $publishAssets = filter_var($publishOpt, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
        }

        $assetsPath = $this->option('assets-path') ?? 'public/vendor/rough-notation';
        $publicUrl = '/vendor/rough-notation';
        if (str_starts_with($assetsPath, 'public/')) {
            $publicUrl = '/' . trim(substr($assetsPath, strlen('public/')), '/');
        }

        $this->publishConfig();
        $this->writeConfig($cdn, $publicUrl);

        if ($publishAssets) {
            Artisan::call('rough:publish-assets', ['--path' => $assetsPath]);
            $this->info('Assets published to ' . $assetsPath);
        }

        $this->info('Installation complete. Add @roughNotationScripts to your layout.');
        return self::SUCCESS;
    }

    protected function publishConfig(): void
    {
        try {
            Artisan::call('vendor:publish', ['--tag' => 'rough-notation-config', '--force' => true]);
        } catch (\Throwable $e) {
        }
    }

    protected function writeConfig(bool $cdn, string $publicUrl): void
    {
        $path = config_path('rough-notation.php');
        $content = "<?php\n\nreturn " . var_export([
            'assets' => [
                'cdn' => $cdn,
                'module_url' => 'https://unpkg.com/rough-notation?module',
                'local' => [
                    'public_url' => $publicUrl,
                    'module' => 'rough-notation.esm.js',
                ],
            ],
        ], true) . ";\n";
        @file_put_contents($path, $content);
    }

    protected function openUrl(string $url): void
    {
        $family = PHP_OS_FAMILY ?? '';
        if ($family === 'Windows') {
            @pclose(@popen('start "" "' . $url . '"', 'r'));
            return;
        }
        if ($family === 'Darwin') {
            @pclose(@popen('open "' . $url . '"', 'r'));
            return;
        }
        @pclose(@popen('xdg-open "' . $url . '"', 'r'));
    }
}
