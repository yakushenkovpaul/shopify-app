<?php

namespace app\Services\Api\Import;

use App\Data as ActiveRecord;
use App\Presenters\Api\ThemeAssetsPresenter;
use App\Presenters\Api\PagesPresenter;
use App\Presenters\Api\SmartCollectionsPresenter;
use App\Presenters\Api\BlogPresenter;
use App\Presenters\Api\BlogArticlesPresenter;

class ImportService
{
    var $config = array();

    public function __construct()
    {
        $config = array(
            'ShopUrl' => $_ENV['PRIVATE_IMPORT_SHOPIFY_SHOP'],
            'ApiKey' => $_ENV['PRIVATE_IMPORT_SHOPIFY_API_KEY'],
            'Password' => $_ENV['PRIVATE_IMPORT_SHOPIFY_API_SECRET']
        );

        $this->config = $config;
    }

    /**
     * Записывает в магазин для импорта блог
     *
     */

    public function setBlog()
    {
        $model = new BlogPresenter(new ActiveRecord());

        if($value = $model->get())
        {
            $connect = new \PHPShopify\ShopifySDK($this->config);

            try {
                $connect->Blog()->post($value);
            }
            catch (\Exception $e) {
                error_log($e->getMessage());
                exit;
            }

            error_log('Asset "' . $value['title'] . '" is added');
            \Log::channel('export')->info('Asset "' . $value['title'] . '" is added');
        }
    }

    /**
     * Записывает в магазин для импорта статьи блога
     *
     * @param integer $blogId
     */

    public function setBlogArticles($blogId)
    {
        $model = new BlogArticlesPresenter(new ActiveRecord());

        if($result = $model->get())
        {
            $connect = new \PHPShopify\ShopifySDK($this->config);

            foreach ($result as $key => $value) {
                try {
                    $connect->Blog($blogId)->Article()->post($value);
                }
                catch (\Exception $e) {
                    error_log($e->getMessage());
                    exit;
                }

                error_log('Article "' . $value['title'] . '" is added');
                \Log::channel('export')->info('Article "' . $value['title'] . '" is added');
            }
        }
    }

    /**
     * Записывает в магазин для импорта ассеты магазина
     * https://help.shopify.com/en/api/reference/online_store/asset#update
     */

    public function setThemeAssets($themeId)
    {
        $model = new ThemeAssetsPresenter(new ActiveRecord());
        $result = $model->get();

        if(!empty($result))
        {
            $connect = new \PHPShopify\ShopifySDK($this->config);

            foreach ($result as $key => $value) {
                try {
                    $connect->Theme($themeId)->Asset()->delete(array('asset[key]' => $value['key']));
                    $connect->Theme($themeId)->Asset()->post($value);
                }
                catch (\Exception $e) {
                    error_log($e->getMessage());
                    exit;
                }

                error_log('Asset "' . $value['key'] . '" is added');
                \Log::channel('export')->info('Asset "' . $value['key'] . '" is added');
            }
        }
    }

    /**
     *  Записывает в магазин для импорта страницы магазина
     *  https://help.shopify.com/en/api/reference/online_store/page#create
     */

    public function setPages()
    {
        $model = new PagesPresenter(new ActiveRecord());
        $result = $model->get();

        if(!empty($result))
        {
            $connect = new \PHPShopify\ShopifySDK($this->config);
            $count = $connect->Page()->count();

            if($count == count($result))
            {
                error_log('Pages have already existed');
                return;
            }

            foreach ($result as $key => $value) {
                try {
                    $connect->Page()->post($value);
                }
                catch (\Exception $e) {
                    error_log($e->getMessage());
                    exit;
                }

                error_log('Page "' . $value['title'] . '" is added');
                \Log::channel('export')->info('Page "' . $value['title'] . '" is added');
            }
        }
    }

    /**
     * Записывает в магазин для импорта "умные коллекции"
     * https://help.shopify.com/en/api/reference/products/smartcollection#create
     */

    public function setSmartCollections()
    {
        $model = new SmartCollectionsPresenter(new ActiveRecord());

        if($total = $model->getTotal())
        {
            $connect = new \PHPShopify\ShopifySDK($this->config);
            $count = $connect->SmartCollection->count();

            if($total == $count)
            {
                error_log('SmartCollections have already imported');
                return;
            }

            for($page = 1; $page <= ceil($total/$_ENV['PRIVATE_EXPORT_SHOPIFY_LIMIT']); $page++)
            {
                if($result = $model->get($page))
                {
                    foreach ($result as $key => $value) {
                        try {
                            $connect->SmartCollection()->post($value);
                        }
                        catch (\Exception $e) {
                            error_log($e->getMessage());
                            exit;
                        }

                        error_log('Smart Collection "' . $value['title'] . '" is added');
                        \Log::channel('export')->info('Smart Collection "' . $value['title'] . '" is added');
                    }
                }
            }
        }
    }
}
