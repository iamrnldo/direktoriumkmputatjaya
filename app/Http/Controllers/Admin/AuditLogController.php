<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($search = $request->input('q')) {
            $query->where('action', 'like', "%{$search}%");
        }
        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        $logs = $query->paginate(25)->withQueryString();
        return view('admin.audit-log', compact('logs'));
    }
}
