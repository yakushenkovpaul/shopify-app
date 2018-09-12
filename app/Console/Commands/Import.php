<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\Api\Import\ThemeAssets;
use App\Jobs\Api\Import\Pages;
use App\Jobs\Api\Import\SmartCollections;
use App\Jobs\Api\Import\Blog;
use App\Jobs\Api\Import\BlogArticles;


class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import {section} {--themeId=} {--blogId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from one shopify store to other';

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

        switch ($section) {
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
                dispatch(new Blog());
                break;
            case 'blogarticles':
                if(!$blogId = $this->option('blogId'))
                {
                    $this->error('The option "blogId" is required. Use --blogId=');
                    exit;
                }
                dispatch(new BlogArticles($blogId));
            break;
        }
    }
}
