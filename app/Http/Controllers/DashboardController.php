<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        if ($user->role === 'admin') {

            return redirect()->route('admin.dashboard');
        }

        if ($user->depart === 'ter' || $user->depart === 'pos') {

            return redirect()->route('schedule.dashboard');
        }

        if ($user->depart === 'upr') {

            return redirect()->route('cassette.dashboard');
        }
    }
}
