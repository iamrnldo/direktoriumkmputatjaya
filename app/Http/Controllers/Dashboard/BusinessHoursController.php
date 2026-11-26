<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessHoursRequest;
use App\Models\BusinessHour;
use App\Models\UmkmProfile;
use App\Services\UmkmService;
use Illuminate\Support\Facades\Auth;

class BusinessHoursController extends Controller
{
    public function __construct(private UmkmService $umkmService) {}

    public function edit()
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())
            ->with('businessHours')
            ->firstOrFail();

        $days = [];
        for ($i = 0; $i <= 6; $i++) {
            $hour = $umkm->businessHours->firstWhere('day_of_week', $i);
            $days[$i] = [
                'name' => BusinessHour::getDayName($i),
                'is_closed' => $hour?->is_closed ?? ($i === 0),
                'open_time' => $hour?->open_time ? substr($hour->open_time, 0, 5) : '08:00',
                'close_time' => $hour?->close_time ? substr($hour->close_time, 0, 5) : '17:00',
            ];
        }

        return view('dashboard.jam-operasional', compact('umkm', 'days'));
    }

    public function update(BusinessHoursRequest $request)
    {
        $umkm = UmkmProfile::where('user_id', Auth::id())->firstOrFail();
        $this->umkmService->updateBusinessHours($umkm, $request->validated()['hours']);

        return back()->with('success', 'Jam operasional berhasil diperbarui.');
    }
}
