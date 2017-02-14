<?php

namespace App\Repositories;

use App\Entities\Tag;

class TagRepository extends BaseRepository
{
    public function model()
    {
        return Tag::class;
    }
}