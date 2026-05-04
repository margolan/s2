<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ScheduleImport;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

use function Pest\Laravel\json;

class ScheduleController extends Controller
{

  public function index(Request $request)
  {

    if (!Cookie::get('settings')) {

      $encode = json_encode(['grafik' => ['aktobe' => true]]);

      Cookie::queue('settings', $encode, 2628000);
    }

    $settings = json_decode(Cookie::get('settings'), true) ?? Cookie::get();

    return view('dashboard.schedule.index', compact('settings'));
  }

  public function settings(Request $request)
  {

    $session = json_decode(Cookie::get('settings'), true);

    if (empty($session['grafik'][$request->depart])) {
      $session['grafik'][$request->depart] = true;
    } else {
      $session['grafik'][$request->depart] = false;
    }

    $encode = json_encode($session);

    Cookie::queue('settings', $encode, 2628000);

    return redirect()->route('schedule-index');
  }

  public function dashboard()
  {

    $allSchedules = Schedule::select('is_active', 'year', 'month')
      ->orderBy('is_active', 'asc')
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->distinct()
      ->get()
      ->groupBy(['is_active', 'year', 'month'])
      ->map(function ($is_active) {
        return $is_active->map(function ($year) {
          return $year->mapWithKeys(function ($month, $index) {
            $monthName = Str::ucfirst(Carbon::create()->month((int)$index)->translatedFormat('F'));
            return [$monthName => $month];
          });
        });
      });

    $actualSchedule = Schedule::where('year', now()->year)
      ->where('month', now()->month)
      ->where('depart', Auth::user()->depart)
      ->get();


    $startOfMonth = Carbon::create(now()->year, now()->month, 1);

    $daysInMonth = $startOfMonth->daysInMonth;

    $calendar = [];
    for ($i = 0; $i < $daysInMonth; $i++) {
      $date = $startOfMonth->copy()->addDays($i);

      $calendar[] = [
        'date' => $date->translatedFormat('j'),
        'dow' => Str::substr($date->translatedFormat('D'), 0, 2),
        'is_weekend' => $date->isWeekend()
      ];
    };


    return view('dashboard.schedule.dashboard', ['allSchedules' => $allSchedules, 'actualSchedule' => $actualSchedule, 'calendar' => $calendar]);
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

    if ($checkExist)     return redirect()->route('schedule-dashboard')->with('status', $request->month . $request->year . $user->depart);

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

    return redirect()->route('schedule-dashboard')->with('status', 'График добавлен. Подтвердите, чтобы он отображался на главной');
  }

  public function activate(Request $request)
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->update(['is_active' => true]);

    return redirect()->route('schedule-dashboard')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' подтвержден');
  }

  public function delete(Request $request)
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->delete();

    return redirect()->route('schedule-dashboard')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' удален');
  }
}
