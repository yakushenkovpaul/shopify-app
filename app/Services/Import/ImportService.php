<?php

namespace app\Services;

class ImportService
{
    var $connect = false;

    public function __construct()
    {
        $config = array(
            'ShopUrl' => $_ENV['PRIVATE_IMPORT_SHOPIFY_SHOP'],
            'ApiKey' => $_ENV['PRIVATE_IMPORT_SHOPIFY_API_KEY'],
            'Password' => $_ENV['PRIVATE_IMPORT_SHOPIFY_API_SECRET']
        );

        $this->connect = new \PHPShopify\ShopifySDK($config);
    }
}
