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


class ScheduleController extends Controller
{

  public function index(Request $request) // =============================== [ INDEX ] ================================================
  {

    $this->checkCookie();

    $settings = json_decode(Cookie::get('settings'), true);

    $selectedDepart = array_keys($settings['grafik']['depart'] ?? [], true);

    $sort = $settings['grafik']['depart']['sort'] ?? true;

    $data = $this->getData($selectedDepart, $sort);

    $data['settings'] = json_decode(Cookie::get('settings'), true) ?? Cookie::get();

    return view('dashboard.schedule.index', ['test' => $settings])->with($data);
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

    $test = $request->sort;

    return redirect()->route('schedule-index', ['test' => $test]);
  }

  public function dashboard() // =============================== [ DASHBOARD ] ================================================
  {

    $this->checkCookie();

    $data = $this->getData([Auth::user()->depart], 'desc');
    $data['formData'] = $this->formData();

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

  private function formData() // =============================== [ FORMDATA ] ================================================
  {

    $months = collect(range(1, 12))->mapWithKeys(function ($month) {
      return [$month => Carbon::now()->month($month)->translatedFormat('F')];
    });

    $years = range(date('Y'), date('Y') + 1);

    $nextMonthDate = Carbon::now()->addMonth();

    $currentMonth = $nextMonthDate->month;
    $currentYear = $nextMonthDate->year;

    return [
      'months' => $months,
      'years' => $years,
      'currentMonth' => $currentMonth,
      'currentYear' => $currentYear
    ];
  }

  private function checkCookie() // =============================== [ COOKIE ] ================================================
  {
    if (!Cookie::get('settings')) {

      $encode = json_encode(['grafik' => [
        'city' => [
          'aktobe' => true,
        ],
        'depart' => [],
      ]]);

      Cookie::queue('settings', $encode, 2628000);
    }
  }

  private function getData($depart, $sort) // =============================== [ GETDATA ] ================================================
  {

    $allSchedules = Schedule::select('is_active', 'year', 'month', 'batch_id')
      ->where('depart', $depart)
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
      ->where('is_active', true)
      ->whereIn('depart', $depart)
      ->orderBy('depart', $sort ? 'asc' : 'desc')
      ->get()
      ->groupBy('depart');


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

    return [
      'allSchedules' => $allSchedules,
      'actualSchedule' => $actualSchedule,
      'calendar' => $calendar,
    ];
  }
}
