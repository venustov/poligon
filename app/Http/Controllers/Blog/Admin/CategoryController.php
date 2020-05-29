<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController;
use App\Http\Requests\BlogCategoryUpdateRequest;
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
    $paginator = BlogCategory::paginate(15);

    return view('blog.admin.categories.index', compact('paginator'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    dd(__METHOD__);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    dd(__METHOD__);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $item = BlogCategory::findOrFail($id);
    $categoryList = BlogCategory::all();

    return view('blog.admin.categories.edit', compact('item', 'categoryList'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(BlogCategoryUpdateRequest $request, $id)
  {
    /*$rules = [
      'title'       => 'required|min:5|max:200',
      'slug'        => 'max:200',
      'description' => 'string|max:500|min:3',
      'parent_id'   => 'required|integer|exists:blog_categories,id',
    ];

    $msg = [
      'description.min' => 'Минимальное количество символов в поле "Описание" - 3',
    ];*/

    //$validatedData = $this->validate($request, $rules, $msg);

    //$validatedData = $request->validate($rules, $msg);

    /*$validator = \Validator::make($request->all(), $rules);
    $validatedData[] = $validator->passes();
    $validatedData[] = $validator->validate();
    $validatedData[] = $validator->valid();
    $validatedData[] = $validator->failed();
    $validatedData[] = $validator->errors();
    $validatedData[] = $validator->fails();*/

    $item = BlogCategory::find($id);
    if (empty($item)) {
      return back()
        ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
        ->withInput();
    }

    $data = $request->all();
    $result = $item
      ->fill($data)
      ->save();

    if ($result) {
      return redirect()
        ->route('blog.admin.categories.edit', $item->id)
        ->with(['success' => 'Успешно сохранено']);
    } else {
      return back()
        ->withErrors(['msg' => 'Ошибка сохранения'])
        ->withInput();
    }
  }

}
