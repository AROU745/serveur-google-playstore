<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index', [
            'plan' => config('services.plan'),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'plan' => config('services.plan'),
        ]);
    }

    public function pricing(): View
    {
        return view('pages.pricing', [
            'plan' => config('services.plan'),
        ]);
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function refundPolicy(): View
    {
        return view('pages.refund-policy');
    }
}
