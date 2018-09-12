<?php

namespace App\Presenters\Api;

use App\Presenters\Api\Presenter;

class BlogArticlesPresenter extends Presenter
{
    const NAME = 'blog_articles';

    /**
     * Сохраняем в базу
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
     * POST /admin/blogs/#{blog_id}/articles.json
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
                    'author' => $a['author'],
                    'tags' => $a['tags'],
                    'body_html' => $a['body_html'],
                    'published_at' => $a['created_at'],
                    'image' => $a['image']
                );
            }
        }

        return $result;
    }
}
