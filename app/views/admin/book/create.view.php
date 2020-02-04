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
    'title' => 'Create book',
    'endpoint' => '/admin/books',
    'method' => 'post'
  ],
  'fields' => [
    [
      'name' => 'name',
      'label' => 'Book name',
      'placeholder' => 'Enter book name',
      'required' => true,
      'col' => 6
    ],
    [
      'type' => 'number',
      'name' => 'price',
      'label' => 'Book price',
      'placeholder' => 'Enter book price',
      'required' => true,
      'col' => 6
    ],
    [
        'name' => 'author',
        'label' => 'Book author name',
        'placeholder' => 'Enter book author name',
        'required' => true,
        'col' => 6
    ],
    [
        'type' => 'number',
        'name' => 'page_count',
        'label' => 'Book page count',
        'placeholder' => 'Enter book page count',
        'required' => true,
        'col' => 6
    ],
    [
      'type' => 'checkbox',
      'name' => 'featured',
      'label' => 'Featured book',
      'value' => false,
      'col' => 6
    ],
    [
      'type' => 'textarea',
      'summernote' => true,
      'name' => 'description',
      'label' => 'Book description',
      'placeholder' => 'Enter book description',
      'required' => true
    ],
    [
      'type' => 'select',
      'options' => $categoryOptions,
      'value' => [],
      'name' => 'category_id',
      'label' => 'Category',
      'required' => true
    ],
    [
      'type' => 'photo',
      'name' => 'main_photo',
      'label' => 'book main photo',
      'value' => null
    ]
  ]
]);

require_view('admin/partials/footer');
