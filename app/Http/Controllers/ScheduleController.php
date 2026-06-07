<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ScheduleImport;
use App\Models\Key;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;



class ScheduleController extends Controller
{

  // =============================================================
  // 
  // Privates: checkCookie, getData, calendar
  // 
  // Publics: index, settings, dashboard, store, activate, delete
  // 
  // =============================================================


  public function index(Request $request) // =============================== [ INDEX ] ================================================
  {


    $settings = $this->checkCookie(); // Cookie

    $data = $this->getData($settings['selectedDepart'], $settings['sort'], $request->y, $request->m); // Month / Schedul Request / Next Month Schedule

    $data['calendar'] = $this->calendar($request->y, $request->m); // Calendar 

    $data['settings'] = $settings; // Settings 

    $data['today'] = now()->day;

    return view('schedule')->with($data);
  }

  public function settings(Request $request) // =============================== [ SETTINGS ] ================================================
  {

    $settings = json_decode(Cookie::get('settings'), true);

    if (empty($settings['grafik']['depart'][$request->depart])) {
      $settings['grafik']['depart'][$request->depart] = true;
    } else {
      $settings['grafik']['depart'][$request->depart] = false;
    }

    $encode = json_encode($settings);

    Cookie::queue('settings', $encode, 2628000);

    return redirect()->route('schedule-index');
  }

  public function dashboard(Request $request) // =============================== [ DASHBOARD ] ================================================
  {

    $settings = $this->checkCookie(); // Cookie

    $data = $this->getData($settings['selectedDepart'], $settings['sort'], $request->y, $request->m); // Month / Schedul Request / Next Month Schedule

    $data['calendar'] = $this->calendar($request->y, $request->m); // Calendar 

    $data['settings'] = $settings; // Settings 

    $data['today'] = now()->day;

    // ================= FORM DATA =================

    $months = collect(range(1, 12))->mapWithKeys(function ($month) {
      return [$month => Carbon::now()->day(1)->month($month)->translatedFormat('F')];
    });

    $years = range(now()->year, now()->year + 1);

    $nextMonthDate = Carbon::now()->addMonth();

    $currentMonth = $nextMonthDate->month;
    $currentYear = $nextMonthDate->year;

    $data['formData'] = [
      'months' => $months,
      'years' => $years,
      'currentMonth' => $currentMonth,
      'currentYear' => $currentYear
    ];

    $data['allSchedules'] = Schedule::select('is_active', 'year', 'month', 'batch_id')
      ->where('depart', Auth::user()->depart)
      ->orderBy('is_active', 'desc')
      ->orderBy('year', 'desc')
      ->orderBy('month', 'desc')
      ->distinct()
      ->get()
      ->groupBy(['is_active', 'year', 'month']);


    return view('dashboard.schedule.dashboard')->with($data);
  }

  public function store(Request $request) // =============================== [ STORE ] ================================================
  {

    $request->validate(
      [
        'file' => ['required', 'mimes:xlsx,xls'],
        'month' => ['required', 'integer', 'between:1,12'],
        'year' => ['required', 'integer'],
      ],
      [
        'file.required' => 'Файл не выбран',
        'file.mimes'    => 'Выбран неверный типа файла',
        'month.between' => 'Месяц должен быть между 1-12',
        'month.integer' => 'Месяц должен быть числом',
        'year.required' => 'Укажите год',
        'year.integer' => 'Год должен быть числом',
      ]
    );

    $user = Auth::user();

    $checkExist = Schedule::where('month', $request->month)->where('year', $request->year)->where('depart', $user->depart)->exists();

    if ($checkExist) return redirect()->route('schedule-dashboard')->with('status', $request->month . $request->year . $user->depart);

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

  public function activate(Request $request) // =============================== [ ACTIVATE ] ================================================
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->update(['is_active' => true]);

    return redirect()->route('schedule-dashboard')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' подтвержден');
  }

  public function delete(Request $request) // =============================== [ DELETE ] ================================================
  {

    $selectedSchedule = Schedule::where('batch_id', $request->batch_id)->first();

    Schedule::where('batch_id', $request->batch_id)->where('depart', Auth::user()->depart)->delete();

    return redirect()->route('schedule-dashboard')->with('status', 'График за ' . Carbon::create($selectedSchedule->year, $selectedSchedule->month)->translatedFormat('F Y') . ' удален');
  }

  private function checkCookie() // =============================== [ COOKIE ] ================================================
  {
    if (!Cookie::get('settings')) {

      $encode = json_encode([
        'grafik' => [
          'city' => ['aktobe' => true],
          'depart' => [],
        ],
      ]);

      Cookie::queue('settings', $encode, 2628000);
    }

    $settings = json_decode(Cookie::get('settings'), true);

    $settings['selectedDepart'] = array_keys($settings['grafik']['depart'] ?? [], true);

    $settings['sort'] = $settings['grafik']['depart']['sort'] ?? true;

    return $settings;
  }

  private function getData($selectedDepart, $sort, $y = null, $m = null)  // =============================== [ GET DATA ] ================================================
  {

    // ================= MONTHS =================


    $month['current'] = Carbon::create(now()->year, now()->month);

    $month['next'] = Carbon::create(now()->year, now()->month)->addMonth();

    $month['isFuture'] = $y && $m;


    // ================= SCHEDULE REQUEST =================

    $query = Schedule::where('is_active', true)
      ->orderBy('depart', $sort ? 'asc' : 'desc');

    if (request()->routeIs('schedule-dashboard')) {

      $query->where('depart', Auth::user()->depart);
    } else {

      $query->whereIn('depart', (array)$selectedDepart);
    }

    if ($y && $m) {

      $query->where('year', $y)
        ->where('month', $m);
    } else {
      $query->where('year', now()->year)
        ->where('month', now()->month);
    }

    $requestedSchedule = $query->get()->groupBy('depart');

    // ================= NEXT MONTH SCHEDULE =================

    $nextMonthSchedule = Schedule::whereIn('depart', ['ter', 'pos'])
      ->where('is_active', true)
      ->where('year', $month['next']->year)
      ->where('month', $month['next']->month)
      ->orderBy('depart', $sort ? 'asc' : 'desc')
      ->get()
      ->groupBy('depart');


    return [
      'requestedSchedule' => $requestedSchedule,
      'nextMonthSchedule' => $nextMonthSchedule,
      'month' => $month,
    ];
  }

  private function calendar($y = null, $m = null) // =============================== [ GETDATA ] ================================================
  {

    if (!$y && !$m) {

      $y = now()->year;
      $m = now()->month;
    }

    $startOfMonth = Carbon::create($y, $m, 1);

    $daysInMonth = $startOfMonth->daysInMonth;

    $calendar = [];

    for ($i = 0; $i < $daysInMonth; $i++) {
      $date = $startOfMonth->copy()->addDays($i);

      $calendar[] = [
        'date' => $date->translatedFormat('j'),
        'dow' => Str::substr($date->translatedFormat('D'), 0, 2),
        'is_weekend' => $date->isWeekend(),
      ];
    };

    return $calendar;
  }
}
