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

    $data = Schedule::where('month', '5')->get()->groupBy('created_at');

    return view('dashboard.schedule.index',compact('data'));
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
    $request->validate([
      'file' => ['required', 'file', 'mimes:xlsx,xls'],
      'month' => ['required', 'integer', 'between:1,12'],
      'year' => ['required', 'integer'],
    ]);

    // Берем данные напрямую из авторизованного пользователя
    $user = Auth::user();

    $spreadsheet = IOFactory::load($request->file('file'));
    $import = new ScheduleImport();

    // Передаем город и департамент пользователя в импорт
    $data = $import->store(
      $spreadsheet,
      $request,
      $user->city,
      $user->depart
    );

    return view('dashboard.schedule.check', ['data' => $data]);
  }

  public function check()
  {

    return view('dashboard.schedule.check');
  }
}
