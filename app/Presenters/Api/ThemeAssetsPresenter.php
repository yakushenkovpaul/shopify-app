<?php

namespace App\Presenters\Api;

use App\Presenters\Api\Presenter;

class ThemeAssetsPresenter extends Presenter
{
    const NAME = 'themeAssets';

    /**
     * Сохраняем в базу
     *
     * @param array $array
     * @param integer $page
     */

    public function save($array)
    {
        $this->model::where('name', self::NAME)->delete();

        $this->model->name = self::NAME;
        $this->model->count = count($array);
        $this->model->json = json_encode($array);
        return $this->model->save();
    }


    /**
     * Возвращает запись из базы
     * https://help.shopify.com/en/api/reference/online_store/asset#update
     *
     * @param integer $page
     */

    public function get()
    {
        $result = array();

        if($row = $this->model::where('name', self::NAME)->first())
        {
            $array = json_decode($row->json, true);

            foreach ($array as $a) {
                $result[] = array(
                    'key' => $a['key'],
                    'source_key' => $a['public_url']
                );
            }
        }

        return $result;
    }
}
