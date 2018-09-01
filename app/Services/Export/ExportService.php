<?php

namespace App\Services\Export;

use App\Presenters\Export\ThemeAssetsPresenter;
use App\Data as ActiveRecord;


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
     * Экспортируем в базу данных ассеты темы
     */

    public function getThemeAssets($themeId)
    {
        $connect = new \PHPShopify\ShopifySDK($this->config);
        $result = $connect->Theme($themeId)->Asset()->get();

        if(!empty($result))
        {
            $model = new ThemeAssetsPresenter(new ActiveRecord());
            $model->save($result);
        }
    }
}
