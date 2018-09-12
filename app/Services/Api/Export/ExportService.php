<?php

namespace App\Services\Api\Export;

use App\Data as ActiveRecord;
use App\Presenters\Api\ThemePresenter;
use App\Presenters\Api\ThemeAssetsPresenter;
use App\Presenters\Api\PagesPresenter;
use App\Presenters\Api\SmartCollectionsPresenter;
use App\Presenters\Api\BlogPresenter;
use App\Presenters\Api\BlogArticlesPresenter;


class ExportService
{
    var $config = array();

    public function __construct()
    {
        $config = array(
            'ShopUrl' => $_ENV['PRIVATE_EXPORT_SHOPIFY_SHOP'],
            'ApiKey' => $_ENV['PRIVATE_EXPORT_SHOPIFY_API_KEY'],
            'Password' => $_ENV['PRIVATE_EXPORT_SHOPIFY_API_SECRET']
        );

        $this->config = $config;
    }

    /**
     * Экспортируем в базу данных тему
     *
     * @param integer $themeId
     */

    public function saveTheme($themeId)
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Theme($themeId)->get();

        if(!empty($result))
        {
            $model = new ThemePresenter(new ActiveRecord());
            $model->save($result);
        }
    }

    /**
     * Экспортируем в базу данных ассеты темы
     *
     * @param integer $themeId
     */

    public function saveThemeAssets($themeId)
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Theme($themeId)->Asset()->get();

        if(!empty($result))
        {
            $model = new ThemeAssetsPresenter(new ActiveRecord());
            $model->save($result);
        }
    }

    /**
     * Записывает в базу данных данные блога
     */

    public function saveBlog($blogId)
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Blog($blogId)->get();

        if(!empty($result))
        {
            $model = new BlogPresenter(new ActiveRecord());
            $model->save($result);
        }
    }

    /**
     * Записывает статьи блога в базу данных
     */

    public function saveBlogArticles($blogId)
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Blog($blogId)->Article()->get();

        if(!empty($result))
        {
            $model = new BlogArticlesPresenter(new ActiveRecord());
            $model->save($result);
        }
    }


    /**
     * Записывает в базу данных созданные страницы
     */

    public function savePages()
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Page()->get();

        if(!empty($result))
        {
            $model = new PagesPresenter(new ActiveRecord());
            $model->save($result);
        }
    }

    /**
     * Записывает в базу данные "умных" коллекций
     */

    public function saveSmartCollections()
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);

        if($total = $connect->SmartCollection()->count())
        {
            $model = new SmartCollectionsPresenter(new ActiveRecord());
            $model->setTotal($total);

            for($page = 1; $page <= ceil($total/$_ENV['PRIVATE_EXPORT_SHOPIFY_LIMIT']); $page++)
            {
                $result = $connect->SmartCollection()->get(array('page' => $page, 'limit' => $_ENV['PRIVATE_EXPORT_SHOPIFY_LIMIT']));

                if(!empty($result))
                {
                    $model = new SmartCollectionsPresenter(new ActiveRecord());
                    $model->save($result, $page);
                }
            }
        }
    }
}
