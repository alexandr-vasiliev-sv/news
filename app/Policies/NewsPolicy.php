<?php

namespace App\Policies;

use App\User;
use App\Entities\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the appNews.
     *
     * @param  \App\User  $user
     * @param  \App\News  $news
     * @return mixed
     */
    public function update(User $user, News $news)
    {
        return $user->id === $news->user_id;
    }

    /**
     * Determine whether the user can delete the appNews.
     *
     * @param  \App\User  $user
     * @param  \App\News  $news
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
        return $user->id === $news->user_id;
    }
}
