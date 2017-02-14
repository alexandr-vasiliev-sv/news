<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

abstract class BaseRepository extends Repository
{
    public function pluck($value, $key = null)
    {
        $this->applyCriteria();
        $lists = $this->model->pluck($value, $key);
        if (is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }
}