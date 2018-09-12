<?php

namespace App\Presenters\Api;

use Illuminate\Database\Eloquent\Model;


abstract class Presenter
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;

        if(!empty($_ENV['PRIVATE_EXPORT_SHOPIFY_TABLE']))
        {
            $this->model->setTable('data_' . $_ENV['PRIVATE_EXPORT_SHOPIFY_TABLE']);
        }
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }
}
