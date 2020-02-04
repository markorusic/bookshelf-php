<?php

// Public Pages routes
$router->get('', 'PublicPagesController@home');
$router->get('categories', 'PublicPagesController@categories');
$router->get('category', 'PublicPagesController@categroy');
$router->get('book', 'PublicPagesController@book');
$router->get('cart', 'PublicPagesController@cart');
$router->get('about', 'PublicPagesController@about');
$router->get('contact', 'PublicPagesController@contact');
$router->get('login', 'PublicAuthController@loginPage');
$router->get('register', 'PublicAuthController@registerPage');
$router->post('login', 'PublicAuthController@login');
$router->post('register', 'PublicAuthController@register');
$router->post('logout', 'PublicAuthController@logout');

// Public API routes
$router->get('api/books/findAll', 'PublicApiController@findBooks');
$router->get('api/books', 'PublicApiController@findbook');
$router->get('api/categories/findAll', 'PublicApiController@findCategories');
$router->post('api/update-user-activity', 'PublicApiController@updateUserActivity');
$router->post('api/contact', 'PublicApiController@contact');

// Admin routes
$router->get('admin/login', 'AdminAuthController@loginPage');
$router->post('admin/login', 'AdminAuthController@login');
$router->post('admin/logout', 'AdminAuthController@logout');
$router->get('admin', 'AdminPagesController@index');
$router->get('admin/page-views', 'AdminPagesController@pageViews');
$router->get('admin/active-users', 'AdminPagesController@activeUsers');
$router->post('admin/upload/photo', 'AdminUploadController@uploadPhoto');
$router->resource('admin/books', 'AdminBookController');
$router->get('admin/books/export', 'AdminBookController@export');
$router->resource('admin/categories', 'AdminCategoryController');
$router->get('admin/categories/export', 'AdminCategoryController@export');
