<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('into-admin');

        $categories = Category::query();

        $categories->when(request('search') ?? false, fn($query, $key) =>
            $query->where('name', 'like', '%'.$key.'%')
        );

        return view('admin.category.index', ['categories' => $categories->paginate(5)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('into-admin');

        return view('admin.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('into-admin');

        $data = $request->validated();

        $data['icon'] = (new CategoryService())->uploadIcons([
            'icon' => $request->file('icon'),
            'category_name' => ucwords($data['name']),
            'slug' => null
        ]);

        $data['name'] = ucwords($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('into-admin');

        return view('admin.category.form', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('into-admin');

        $data = $request->validated();

        if ($data['name'] !== $category->name)
        {
            $category->name = ucwords($data['name']);
        }

        if ($request->file('icon'))
        {
            $category->icon = (new CategoryService())->uploadIcons([
                'icon' => $request->file('icon'),
                'category_name' => ucwords($data['name']),
                'slug' => $category->slug
            ]);
        }

        $category->save();

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('into-admin');

        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
