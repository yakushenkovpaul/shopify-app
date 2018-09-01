<?php

namespace App\Presenters\Export;

use App\Presenters\Export\Presenter;

class ThemeAssetsPresenter extends Presenter
{
    const NAME = 'themeAssets';

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
}
