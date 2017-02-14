<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.02.17
 * Time: 17:40
 */

namespace App\Repositories\Criteria;


use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class SearchNewsByTags extends Criteria
{
    private $_tagsId;

    public function __construct($tagId)
    {
        if ($tagId !== null) {
            $this->_tagsId = (int)$tagId;
        }
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if ($this->_tagsId !== null) {
            $model = $model->whereHas('tags', function ($query) {
                $query->where('id', $this->_tagsId);
            });
        }
        return $model;
    }
}