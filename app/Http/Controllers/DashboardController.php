<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class DashboardController extends Controller
{

    public function index()
    {

        $yearAndMonth['month'] = array_map(fn($month) => Carbon::create(0, $month)->translatedFormat('F'), range(1, 12));
        $yearAndMonth['year'] = range(date('Y'), date('Y') + 1);
        $yearAndMonth['current'] = [date('n', mktime(0, 0, 0, 1, 1, 2025)) == 12 ? 0 : date('n') - 1, date('n', mktime(0, 0, 0, 1, 1, 2025)) == 12 ? 2026 : 2025];

        return view('dashboard', compact('yearAndMonth'));
    }
}
