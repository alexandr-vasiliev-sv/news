<?php

namespace App\Repositories;

use App\Entities\News;

class NewsRepository extends BaseRepository
{
    public function model()
    {
        return News::class;
    }
}