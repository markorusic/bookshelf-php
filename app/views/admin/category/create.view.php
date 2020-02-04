<?php

require_view('admin/partials/header');

form([
  'meta' => [
    'title' => 'Create category',
    'endpoint' => '/admin/categories',
    'method' => 'post'
  ],
  'fields' => [
    [
      'name' => 'name',
      'label' => 'Category name',
      'placeholder' => 'Enter category name',
      'required' => true,
      'col' => 6
    ],
    [
      'type' => 'textarea',
      'summernote' => true,
      'name' => 'description',
      'label' => 'Category description',
      'placeholder' => 'Enter category description',
      'required' => true
    ],
    [
      'type' => 'photo',
      'name' => 'main_photo',
      'label' => 'Category main photo'
    ]
  ]
]);

require_view('admin/partials/footer');
