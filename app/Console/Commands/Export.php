<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Api\Export\Theme;
use App\Jobs\Api\Export\ThemeAssets;
use App\Jobs\Api\Export\Pages;
use App\Jobs\Api\Export\SmartCollections;
use App\Jobs\Api\Export\Blog;
use App\Jobs\Api\Export\BlogArticles;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export {section} {--themeId=} {--blogId=}';

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
        $section = strtolower($this->argument('section'));

        switch($section)
        {
            case 'theme':
                if(!$themeId = $this->option('themeId'))
                {
                    $this->error('The option "themeId" is required. Use --themeId=');
                    exit;
                }
                //34216869999
                dispatch(new Theme($themeId));
            break;

            case 'themeassets':
                if(!$themeId = $this->option('themeId'))
                {
                    $this->error('The option "themeId" is required. Use --themeId=');
                    exit;
                }
                //31902072905
                dispatch(new ThemeAssets($themeId));
            break;

            case 'pages':
                dispatch(new Pages());
            break;

            case 'smartcollections':
                dispatch(new SmartCollections());
            break;

            case 'blog':
                if(!$blogId = $this->option('blogId'))
                {
                    $this->error('The option "blogId" is required. Use --blogId=');
                    exit;
                }
                //103875668
                dispatch(new Blog($blogId));
            break;

            case 'blogarticles':
                if(!$blogId = $this->option('blogId'))
                {
                    $this->error('The option "blogId" is required. Use --blogId=');
                    exit;
                }
                //103875668
                dispatch(new BlogArticles($blogId));
            break;
        }
    }
}
