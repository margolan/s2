<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ScheduleImport;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
{

  public function index()
  {

    $data = Schedule::orderBy('is_active', 'desc')
      ->orderBy('year')
      ->orderBy('month')
      ->get()
      ->groupBy(['is_active', 'year', 'month'])
      ->map(function ($isActive) {
        return $isActive->map(function ($month) {
          return $month->mapWithKeys(function ($data, $index) {
            $monthName = Carbon::create(null, $index)->translatedFormat('F');
            return [$monthName => $data];
          });
        });
      });


    return view('dashboard.schedule.index', compact('data'));
  }

  public function create()
  {

    $months = collect(range(1, 12))->mapWithKeys(function ($month) {
      return [$month => Carbon::now()->month($month)->translatedFormat('F')];
    });

    $years = range(date('Y'), date('Y') + 1);

    $nextMonthDate = Carbon::now()->addMonth();

    $currentMonth = $nextMonthDate->month;
    $currentYear = $nextMonthDate->year;

    return view('dashboard.schedule.create', compact('months', 'years', 'currentMonth', 'currentYear'));
  }

  public function store(Request $request)
  {

    $user = Auth::user();

    $checkExist = Schedule::where('month', $request->month)->where('year', $request->year)->where('depart', $user->depart)->exists();

    if ($checkExist)     return redirect()->route('schedule-index')->with('status', $request->month . $request->year . $user->depart);

    $request->validate([
      'file' => ['required', 'file', 'mimes:xlsx,xls'],
      'month' => ['required', 'integer', 'between:1,12'],
      'year' => ['required', 'integer'],
    ]);


    $spreadsheet = IOFactory::load($request->file('file'));
    $import = new ScheduleImport();

    $import->store(
      $spreadsheet,
      $request,
      $user->city,
      $user->depart,
    );

    return redirect()->route('schedule-index')->with('status', 'График добавлен. Подтвердите, чтобы он отображался на главной');
  }

  public function activate(Request $request)
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->update(['is_active' => true]);

    return redirect()->route('schedule-index')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' подтвержден');
  }

  public function delete(Request $request)
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->delete();

    return redirect()->route('schedule-index')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' удален');
  }
}
