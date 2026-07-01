<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $users = User::all();





        $allSchedules  = Schedule::get()->groupBy(['depart', 'batch_id']);

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::now()->day(1)->month($month)->translatedFormat('F')];
        });

        $years = range(now()->year, now()->year + 1);

        $nextMonthDate = Carbon::now()->addMonth();

        $currentMonth = $nextMonthDate->month;
        $currentYear = $nextMonthDate->year;

        $formData = [
            'months' => $months,
            'years' => $years,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear
        ];

        // ======================== Visitors

        $query = Visitor::orderBy('id', 'desc')->take(100)->get();

        $visitors['allRows'] = $query;
        $visitors['byResources'] = $query->groupBy('url')->map(function ($item) {
            return $item->count();
        });
        $test['b'] = '';

        return view('dashboard.admin.dashboard', compact('users', 'allSchedules', 'formData', 'visitors', 'test'));
    }

    public function edit(Request $request)
    {

        $user = User::findOrFail($request->id);

        return view('dashboard.admin.element.user', compact('user'));
    }

    public function update(Request $request)
    {

        $user = User::findOrFail($request->id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'depart' => 'required',
            'city' => 'required',
            'active' => 'required',
        ]);

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('status', 'Данные ' . $user->name . ' обновлены');
    }
}
