<?php

namespace App\Controllers;

use App\Core\Http\Controller;
use App\Models\{Book, Category};
use App\Services\LoggingService;

class PublicPagesController extends Controller
{
    public function home()
    {
        LoggingService::trackPageVisit('Home');
        return view('public/home');
    }

    public function categories()
    {
        LoggingService::trackPageVisit('Categories');
        return view('public/categories');
    }

    public function categroy()
    {
        $this->validateQuery([ 'id' => 'required' ], 'view');
        $category = Category::find($this->query['id']);
        if (!$category) {
            $message = 'Category not found';
            return abort_view(404, compact('message'));
        }
        LoggingService::trackPageVisit('Category: ' . $category->name);
        return view('public/category', compact('category'));
    }

    public function Book()
    {
        $this->validateQuery([ 'id' => 'required' ], 'view');
        $book = Book::find($this->query['id']);
        if (!$book) {
            $message = 'Book not found';
            return abort_view(404, compact('message'));
        }
        LoggingService::trackPageVisit('Book: ' . $book->name);
        return view('public/book', compact('book'));
    }

    public function about()
    {
        LoggingService::trackPageVisit('About');
        return view('public/about');
    }

    public function cart()
    {
        LoggingService::trackPageVisit('Cart');
        return view('public/cart');
    }

    public function contact()
    {
        LoggingService::trackPageVisit('Contact');
        return view('public/contact');
    }
}
