<?php

namespace App\Presenters\Api;

use App\Presenters\Api\Presenter;

class PagesPresenter extends Presenter
{
    const NAME = 'pages';

    /**
     * Сохраняем в базу
     */

    public function save($array)
    {
        $this->model::where('name', self::NAME)->delete();

        $this->model->name = self::NAME;
        $this->model->json = json_encode($array);
        return $this->model->save();
    }


    /**
     * Возвращает запись из базы
     * https://help.shopify.com/en/api/reference/online_store/page#create
     */

    public function get()
    {
        $result = array();

        if($row = $this->model::where('name', self::NAME)->first())
        {
            $array = json_decode($row->json, true);

            foreach ($array as $a) {
                $result[] = array(
                    'title' => $a['title'],
                    'body_html' => $a['body_html']
                );
            }
        }

        return $result;
    }
}
