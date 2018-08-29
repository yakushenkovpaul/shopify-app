<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class WrapController extends Controller
{
		public function page()
		{
			$config = array(
				'ShopUrl' => 'birkastyle.myshopify.com',
				'ApiKey' => '9a65e3a7bc406d57c60cfe1bece6aea7',
				'Password' => 'e0491522870cf30b73d5a88a35e64f1b'
			);

			$shopify = new \PHPShopify\ShopifySDK($config);
			$result = $shopify->Page->get();

		}

    public function index()
    {
        $config = array(
            'ShopUrl' => 'birkastyle.myshopify.com',
            'ApiKey' => '9a65e3a7bc406d57c60cfe1bece6aea7',
            'Password' => 'e0491522870cf30b73d5a88a35e64f1b'
        );

        $shopify = new \PHPShopify\ShopifySDK($config);
        $result = $shopify->Order->get();
    }

    public function getProduct()
    {
        $config = array(
            'ShopUrl' => 'pyaktest.myshopify.com',
            'ApiKey' => '9a65e3a7bc406d57c60cfe1bece6aea7',
            'Password' => 'b3881b164806a5c4938513279a1f14ee'
        );

        $productID = 1781895528506;

        $shopify = new \PHPShopify\ShopifySDK($config);
        $products = $shopify->Product($productID)->get();

        #$productImages = $shopify->Product($productID)->Image->get();
        #$productVariants = $shopify->Product($productID)->Variant->get();
    }

}
