<?php

namespace App\Controllers;

use App\Models\{Book, Category};
use App\Services\ExportService;

class AdminBookController extends AdminController
{
    public function showAll()
    {
        $book = Book::findAll();
        return view('admin/book/index', compact('book'));
    }

    public function create()
    {
        $categories = Category::findAll();
        return view('admin/book/create', compact('categories'));
    }

    public function edit()
    {
        $this->validateQuery([ 'id' => 'required' ], 'view');
        $book = Book::find($this->query['id']);
        if (!$book) {
            return abort_view(404, [
                'message' => 'Book not found.'
            ]);
        }
        $categories = Category::findAll();
        return view('admin/book/edit', compact('book', 'categories'));
    }

    public function index()
    {
        return json(Book::findPage([
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
        $book = Book::find($this->query['id']);
        return json($book);
    }

    public function store()
    {
        $this->validateBody([
            'price' => 'required',
            'name' => 'required',
            'description' => 'required',
            'main_photo' => 'required',
            'author' => 'required'
        ]);
        return json(Book::create($this->body));
    }

    public function update()
    {
        $this->validateQuery([ 'id' => 'required' ]);
        $this->validateBody([
            'price' => 'required',
            'name' => 'required',
            'description' => 'required',
            'main_photo' => 'required',
            'author' => 'required'
        ]);
        return json(Book::update($this->query['id'], $this->body));
    }

    public function destroy()
    {
        $this->validateQuery([ 'id' => 'required' ]);
        return json(Book::delete([
            'id' => $this->query['id']
        ]));
    }

    public function export()
    {
        ExportService::excel([
            "filename" => "books",
            "columns" => ['name', 'price', 'description', 'author', 'created_at', 'updated_at'],
            "data" => Book::findAll()
        ]);
    }
}
