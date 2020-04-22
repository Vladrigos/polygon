<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    //массив тех полей которые функция fill может заполнить
    protected $fillable = [
            'title',
            'slug',
            'parent_id',
            'description',
        ];


}
