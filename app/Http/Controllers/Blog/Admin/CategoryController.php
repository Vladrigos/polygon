<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

/**
 * Управление категориями блога
 *
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */

class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$paginator = BlogCategory::paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList =
            $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        //при нажатии сохранить с create попадаем в store
        $data = $request->input();
        /*ушло в обсервер
        if(empty($data['slug']))
        {
            $data['slug'] = str_slug($data['title']);
        }
        */
        //Создаст обьект но НЕ добавит в бд
        /*
        $item = new BlogCategory($data);
        $item->save();
        */
        //Создаст обьект и добавит в бд
        $item = (new BlogCategory())->create($data);

        if($item)
        {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено!']);
        }
        else
        {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //ларавель сам создаст обьект класа BlogCategoryRepository
    //если было бы ($id, BlogCategoryRepository $categoryRepository)
    public function edit($id)
    {
        /*
        //в учебных целях, в нормальном проекте так не надо
        $item = BlogCategory::find($id);
        //аккуратнее с find or fail, ибо если где то вглубине кода оно будет, и вылезет ошибка,
        // то хрен найдёшь без ошибки
        $item = BlogCategory::findOrFail($id);
        //$item = BlogCategory::where('id', '=', $id)->first();
        //dd($item->pluck('id'));
        */
        //дай запись для edit по id
        $item = $this->blogCategoryRepository->getEdit($id);
        if(empty($item))
        {
            abort(404);
        }
        $categoryList =
            $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
        //compact - передали параметры во view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        /*
        $rules = [
            'title'         => 'required|min:5|max:200',
            'slug'          => 'max:200',
            'description'   => 'string|max:500|min:3',
            'parent_id'     => 'required|integer|exists:blog_categories,id',
            //в таблице blog_categories должно быть найдено поле id
        ];
        //validate автоматически редиректит назад with->errors
        //порождаем сами валидатор, есть настройки полезные
        //$validator = \Validator::make($request->all(), $rules);
        BlogCategoryUpdateRequest сделает автоматически validate
        $validatedData = $request->validate($rules);
        $validatedData = $this->validate($request, $rules);
        */
        //$item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item))
        {
            //back это helper ская функция, которая редиректит назад
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                //вернуть инпуты которые были введены что бы не вводить всё заново при ошибке
                ->withInput();
        }

        $data = $request->all();
        /*
         * //ушло в обсервер
        if(empty($data['slug']))
        {
            $data['slug'] = Str::slug($data['title']);
        }
        */
        //одно и то же
        //$result = $item->fill($data)->save();
        $result = $item->update($data);
        if($result)
        {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                //через session передаём "сообщение"
                ->with(['success' => 'Успешно сохранено']);
        }
        else
        {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
