<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository
 * @package App\Repositories
 */
class BlogCategoryRepository extends CoreRepository
{
    /**
     * Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список категорий для вывода в выпадающем списке.
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        //return $this->startConditions()->all();

        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);
        //id_title это 3. Категория #3 (конкатенируем 2 строки, делаем для view)
        /*
        $result[] = $this->startConditions()->all();
        $result[] = $this
            ->startConditions()
            ->select('blog_categories.*',
            \DB::raw('CONCAT (id, ". ", title) AS id_title'))
            //не агрегировать полученные данные в обьекты класса BlogCategory
            ->toBase()
            ->get();
        //raw сырые данные
        */
        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            //SELECT
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

}
