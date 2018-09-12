<?php

namespace App\Presenters\Api;

use App\Presenters\Api\Presenter;

class BlogPresenter extends Presenter
{
    const NAME = 'blog';

    /**
     * Сохраняем в базу
     */

    public function save($array)
    {
        $this->model::where('name', self::NAME)->delete();

        $this->model->name = self::NAME;
        $this->model->count = 1;
        $this->model->json = json_encode($array);
        return $this->model->save();
    }


    /**
     * Возвращает запись из базы
     * https://help.shopify.com/en/api/reference/online_store/blog#create
     */

    public function get()
    {
        $result = array();

        if($row = $this->model::where('name', self::NAME)->first())
        {
            $a = json_decode($row->json, true);

            $result = array(
                'title' => $a['title']/* ,
                'metafields' => array(
                    'key' => 'tags',
                    'value' => $a['tags'],
                    'value_type' => 'string',
                    'namespace' => 'global'
                ) */
            );
        }

        return $result;
    }
}
