<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.02.17
 * Time: 13:34
 */

namespace App\Repositories;

use App\Entities\Category;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }
}