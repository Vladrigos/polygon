<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    /**
     * Если дата публикации не установлена и ispublished = true(опубликовано)
     * то устанавливаем дату публикации на текущую
     *
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if(empty($blogPost->published_at) && $blogPost->is_published)
        {
            $blogPost->published_at = Carbon::now;
        }
    }

    protected function setSlug(BlogPost $blogPost)
    {
        if(empty($blogPost->slug))
        {
            $blogPost->slug = \Str::slug($blogPost->title);
        }
    }
    /**
     * Handle the blog post "created" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Изменение ПЕРЕд обновлением записи
     *
     * @param BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost)
    {
        /*
         * изменялась ли вообще модель, а вдруг с сохранения попали и ничего не поменялось
        $test[] = $blogPost->isDirty();
        проверяем одно поле на изменение
        $test[] = $blogPost->isDirty('is_published');
        $test[] = $blogPost->isDirty('user_id');
        получить значение атрибута который полетит в базу
        $test[] = $blogPost->getAttribute('is_published');
        тоже самое
        $test[] = $blogPost->is_published;
        получаем старое значение, которое в базе
        $test[] = $blogPost->getOriginal('is_published');
        получаем изменённые поля
        $test[] = $blogPost->getDirty();
        */
        $test[] = $blogPost->isDirty();
        dd($test);
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

        //если return false, то сохранение отменится.
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
