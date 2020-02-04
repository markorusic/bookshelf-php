<?php

require_view('admin/partials/header');

form([
  'meta' => [
    'title' => "Update category {$category->name}",
    'endpoint' => "/admin/categories/update?id={$category->id}",
    'method' => 'put'
  ],
  'fields' => [
    [
      'name' => 'name',
      'label' => 'Category name',
      'placeholder' => 'Enter category name',
      'required' => true,
      'value' => $category->name,
      'col' => 6
    ],
    [
      'type' => 'textarea',
      'summernote' => true,
      'name' => 'description',
      'label' => 'Category description',
      'placeholder' => 'Enter category description',
      'required' => true,
      'value' => $category->description
    ],
    [
      'type' => 'photo',
      'name' => 'main_photo',
      'label' => 'Category main photo',
      'value' => $category->main_photo
    ]
  ]
]);

require_view('admin/partials/footer');
