<?php

require_view('admin/partials/header');

$categoryOptions = array_map(function ($category) {
  return [
      'value' => $category->id,
      'display' => $category->name
  ];
}, $categories);

form([
  'meta' => [
    'title' => "Update book {$book->name}",
    'endpoint' => "/admin/books/update?id={$book->id}",
    'method' => 'put'
  ],
  'fields' => [
    [
      'name' => 'name',
      'label' => 'Book name',
      'placeholder' => 'Enter book name',
      'required' => true,
      'value' => $book->name,
      'col' => 6
    ],
    [
        'type' => 'number',
        'name' => 'price',
        'label' => 'Book price',
        'placeholder' => 'Enter book price',
        'required' => true,
        'value' => $book->price,
        'col' => 6
    ],
    [
        'name' => 'author',
        'label' => 'Book author name',
        'placeholder' => 'Enter book author name',
        'required' => true,
        'value' => $book->author,
        'col' => 6
    ],
    [
        'type' => 'number',
        'name' => 'page_count',
        'label' => 'Book Page count',
        'placeholder' => 'Enter book Page count',
        'required' => true,
        'value' => $book->page_count,
        'col' => 6
    ],
    [
        'type' => 'checkbox',
        'name' => 'featured',
        'label' => 'Featured book',
        'value' => $book->featured,
        'col' => 6
    ],
    [
      'type' => 'textarea',
      'summernote' => true,
      'name' => 'description',
      'label' => 'Book description',
      'placeholder' => 'Enter book description',
      'required' => true,
      'value' => $book->description
    ],
    [
      'type' => 'select',
      'options' => $categoryOptions,
      'value' => $book->category_id,
      'name' => 'category_id',
      'label' => 'Category',
      'required' => true
    ],
    [
      'type' => 'photo',
      'name' => 'main_photo',
      'label' => 'book main photo',
      'value' => $book->main_photo
    ]
  ]
]);

require_view('admin/partials/footer');
