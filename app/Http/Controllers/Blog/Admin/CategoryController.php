<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //в учебных целях, в нормальном проекте так не надо
        $item = BlogCategory::find($id);
        //аккуратнее с find or fail, ибо если где то вглубине кода оно будет, и вылезет ошибка,
        // то хрен найдёшь без ошибки
        $item = BlogCategory::findOrFail($id);
        //$item = BlogCategory::where('id', '=', $id)->first();
        //dd($item->pluck('id'));
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
        //compact - передали параметры во view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item))
        {
            //back это helper ская функция, которая редиректит назад
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                //вернуть инпуты которые были введены что бы не вводить всё заново при ошибке
                ->withInput();
        }

        $data = $request->all();
        $result = $item->fill($data)->save();

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
