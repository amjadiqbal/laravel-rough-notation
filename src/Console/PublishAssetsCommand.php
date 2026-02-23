<?php

namespace AmjadIqbal\RoughNotation\Console;

use Illuminate\Console\Command;

class PublishAssetsCommand extends Command
{
    protected $signature = 'rough:publish-assets {--path=public/vendor/rough-notation}';
    protected $description = 'Download Rough Notation module script to a local public path';

    public function handle()
    {
        $path = $this->option('path');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $moduleUrl = (string) config('rough-notation.assets.module_url', 'https://unpkg.com/rough-notation?module');
        $localModule = (string) config('rough-notation.assets.local.module', 'rough-notation.esm.js');

        if ($moduleUrl) {
            $data = @file_get_contents($moduleUrl);
            if ($data !== false) {
                file_put_contents($path . '/' . $localModule, $data);
                $this->info('Downloaded ' . $localModule);
            } else {
                $this->error('Failed to download module from ' . $moduleUrl);
            }
        }

        $this->info('Rough Notation assets published to ' . $path);
        return self::SUCCESS;
    }
}
