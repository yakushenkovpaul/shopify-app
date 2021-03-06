<?php

namespace App\Jobs\Api\Export;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Api\Export\ExportService;


class ThemeAssets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    var $themeId = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($themeId)
    {
        $this->themeId = $themeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service_export = new ExportService;
        $service_export->saveThemeAssets($this->themeId);
    }
}
