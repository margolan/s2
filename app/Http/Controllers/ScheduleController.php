<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{

  public function create()
  {

    $date['month'] = array_map(fn($month) => Carbon::create(0, $month)->translatedFormat('F'), range(1, 12));
    $date['year'] = range(date('Y'), date('Y') + 1);
    $date['current'] = [date('n') == 12 ? 0 : date('n') - 1, date('n') == 12 ? date('Y') + 1 : date('Y')];

    return view('dashboard.schedule.create', ['date' => $date]);
  }
}
