<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExportThemeAssets;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export {section} {--themeId=}';

    /**php
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export data from one shopify store to other';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $section = $this->argument('section');

        switch($section)
        {
            case 'themeassets':
            if(!$themeId = $this->option('themeId'))
            {
                $this->error('The option "themeId" is required. Use --themeId=');
                exit;
            }
            //31902072905
            dispatch(new ExportThemeAssets($themeId));
            break;
        }
    }
}
