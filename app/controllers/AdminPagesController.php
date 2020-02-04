<?php

namespace App\Controllers;
use App\Services\LoggingService;
use App\Models\User;

class AdminPagesController extends AdminController
{

    public function index()
    {
        return view('admin/home');
    }

    public function pageViews()
    {
        $tracking_data = LoggingService::getPageVisits();
        return json($tracking_data);
    }

    public function activeUsers() 
    {
        return json(User::findActive());
    }
}
