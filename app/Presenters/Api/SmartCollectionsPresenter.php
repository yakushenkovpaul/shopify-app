<?php

namespace App\Presenters\Api;

use App\Presenters\Api\Presenter;

class SmartCollectionsPresenter extends Presenter
{
    const NAME = 'smartcollections';

    /**
     * Сохраняем в базу информацию
     *
     * @param array $array
     * @param integer $page
     */

    public function save($array, $page)
    {
        $this->model::where('name', self::NAME . '_' . $page)->delete();

        $this->model->name = self::NAME . '_' . $page;
        $this->model->count = count($array);
        $this->model->json = json_encode($array);
        return $this->model->save();
    }

    /**
     * Возвращает запись из базы
     * https://help.shopify.com/en/api/reference/products/smartcollection#create
     *
     * @param integer $page
     */

    public function get($page)
    {
        $result = array();

        if($row = $this->model::where('name', self::NAME . '_' . $page)->first())
        {
            $array = json_decode($row->json, true);

            $count = 0;
            foreach ($array as $a) {

                $rules = (!empty($a['rules']))  ?   $a['rules'] :   array();
                $image = (!empty($a['rules']))  ?   $a['rules'] :   array();

                $result[$count]['title'] = $a['title'];

                if(!empty($a['rules']))
                {
                    $result[$count]['rules'] = $a['rules'];
                }

                if(!empty($a['image']))
                {
                    $result[$count]['image'] = array(
                        'src' => $a['image']['src'],
                        'alt' => $a['image']['alt']
                    );
                }

                $count++;
            }
        }

        return $result;
    }


    /**
     * Сохраняет в базу кол-во объектов
     *
     * @param integer $total
     */

    public function setTotal($total)
    {
        $this->model::where('name', self::NAME . '_total')->delete();

        $this->model->name = self::NAME . '_total';
        $this->model->count = $total;
        $this->model->json = json_encode(array());
        return $this->model->save();
    }

    /**
     * Возвращает общее кол-во результатов
     */

    public function getTotal()
    {
        if($row = $this->model::where('name', self::NAME . '_total')->first())
        {
            return $row->count;
        }

        return 0;
    }
}
