<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\ScheduleImport;
use App\Models\Schedule;
use DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ReturnTypeWillChange;
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
{

  public function index()
  {

    $data = Schedule::get()->groupBy('month');

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

    if ($checkExist)     return redirect()->route('schedule-index')->with('status', 'Schedule already exist');


    $request->validate([
      'file' => ['required', 'file', 'mimes:xlsx,xls'],
      'month' => ['required', 'integer', 'between:1,12'],
      'year' => ['required', 'integer'],
    ]);


    $spreadsheet = IOFactory::load($request->file('file'));
    $import = new ScheduleImport();

    // Передаем город и департамент пользователя в импорт
    // $data = $import->store(
    $import->store(
      $spreadsheet,
      $request,
      $user->city,
      $user->depart
    );

    // return view('dashboard.schedule.check', ['data' => $data]);
    return redirect()->route('schedule-index');
  }

  public function delete(Request $request) {}
}
