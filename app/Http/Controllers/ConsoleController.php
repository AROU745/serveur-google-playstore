<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ConsoleController extends Controller
{
    public function index(): View
    {
        return view('console.index', [
            'apps' => config('console.apps', []),
        ]);
    }
}
