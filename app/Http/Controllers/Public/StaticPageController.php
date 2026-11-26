<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        $page = StaticPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.static-page', compact('page'));
    }
}
