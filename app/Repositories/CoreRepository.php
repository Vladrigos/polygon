<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 *
 * @package App\Repositories
 *
 * Репозиторий работы с сущностью.
 * Может выдавать наборы данных.
 * Не может изменять/создавать сущности.
 */
abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        //создаем модель, почти тоже самое что $this->model = new ($this->>getModelClass())
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Model|\Illuminate\Foundation\Application|mixed
     */
    //что бы не сохранялось состояние
    protected function startConditions()
    {
        return clone $this->model;
    }
}
