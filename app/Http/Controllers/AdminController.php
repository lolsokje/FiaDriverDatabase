<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Index');
    }

    public function login(): Response
    {
        return Inertia::render('Admin/Login');
    }
}
