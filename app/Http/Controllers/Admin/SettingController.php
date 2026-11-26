<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.pengaturan', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            SiteSetting::where('key', $key)->update(['value' => $value]);
            Cache::forget("site_setting_{$key}");
        }

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
