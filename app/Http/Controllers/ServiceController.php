<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class ServiceController extends Controller
{
    public function pincode(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'pincode' => 'required|digits:4',
            ]);

            $users = User::whereIn('email', ['ter@0x0.kz', 'ter1@0x0.kz'])->get();

            foreach ($users as $user) {
                if (Hash::check($request->pincode, $user->password)) {

                    Auth::login($user);
                    $request->session()->regenerate();

                    return redirect()->intended(route('key-dashboard'))->with('status', 'Вы авторизованы');
                }
            }

            return back()->withErrors([

                'pincode' => 'Неверный пин-код.',

            ]);
        }

        $routes = URL::previousPath();

        return view('dashboard.pincode', compact('routes'));
    }
}
