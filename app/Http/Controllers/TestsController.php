<?php

namespace App\Http\Controllers;

class TestsController extends Controller
{

    /**
     * TestsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($view = 'steamapitests')
    {
        return view($view);
    }
}
