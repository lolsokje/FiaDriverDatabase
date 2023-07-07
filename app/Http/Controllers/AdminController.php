<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    public function index(): RedirectResponse
    {
        return to_route('admin.drivers.index');
    }

    public function login(): Response
    {
        return Inertia::render('Admin/Login');
    }
}
