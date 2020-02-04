<?php

namespace App\Controllers;

use App\Models\Category;
use App\Services\ExportService;

class AdminCategoryController extends AdminController
{
    public function showAll()
    {
        $categories = Category::findAll();
        return view('admin/category/index', compact('categories'));
    }

    public function create()
    {
        return view('admin/category/create');
    }

    public function edit()
    {
        $this->validateQuery([ 'id' => 'required' ], 'view');
        $category = Category::find($this->query['id']);
        if (!$category) {
            return abort_view(404, [
                'message' => 'Category not found.'
            ]);
        }
        return view('admin/category/edit', compact('category'));
    }

    public function index()
    {
        return json(Category::findPage([
            'page' => $this->query['page'],
            'size' => $this->query['size'],
            'sort' => $this->query['sort'],
            'options' => [
                ['name', 'like', "%{$this->query['name']}%"]
            ]
        ]));
    }

    public function show() {
        $this->validateQuery([ 'id' => 'required' ]);
        $category = Category::find($this->query['id']);
        return json($category);
    }

    public function store()
    {
        $this->validateBody([
            'name' => 'required',
            'description' => 'required',
            'main_photo' => 'required'
        ]);
        return json(Category::create($this->body));
    }

    public function update()
    {
        $this->validateQuery([ 'id' => 'required' ]);
        $this->validateBody([
            'name' => 'required',
            'description' => 'required',
            'main_photo' => 'required'
        ]);
        return json(Category::update($this->query['id'], $this->body));
    }

    public function destroy()
    {
        $this->validateQuery([ 'id' => 'required' ]);
        return json(Category::delete([
            'id' => $this->query['id']
        ]));
    }

    public function export()
    {
        ExportService::excel([
            "filename" => "categories",
            "columns" => ['name', 'description', 'created_at', 'updated_at'],
            "data" => Category::findAll()
        ]);
    }
}
