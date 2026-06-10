<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Imports\KeyImport;
use App\Models\Key;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class KeyController extends Controller
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

        return view('dashboard.key.pincode');
    }


    public function dashboard()
    {

        $districtNames = [
            'ct' => 'Город',
            '8' => '8 мкр',
            '11' => '11 мкр',
            '12' => '12 мкр',
            'old' => 'Старый город',
            'far' => 'Дальние',
        ];

        $data = Key::orderBy('id')
            ->get()
            ->groupBy('district')->mapWithKeys(function ($data, $index) use ($districtNames) {
                return [$districtNames[$index] ?? "Неизвестный район ($index)" => $data];
            });

        $report = $data->map(function ($data, $index) {
            return $data->count();
        });

        $availableKeys = Key::select('batch_id')->distinct()->first();

        return view('dashboard.key.dashboard', ['report' => $report, 'data' => $data, 'availableKeys' => $availableKeys]);
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'file' => ['required', 'mimes:xlsx,xls'],
            ],
            [
                'file.required' => 'Файл не выбран',
                'file.mimes'    => 'Выбран неверный типа файла',
            ]
        );

        $spreadsheet = IOFactory::load($request->file('file'));
        $import = new KeyImport();

        $data = $import->store($spreadsheet);

        return redirect()->back()->with('status', 'Upload successfull');
    }

    public function edit(Request $request)
    {

        $retrievedData = Key::where('reg_number', $request->query('d'))->firstOrFail();

        if ($request->isMethod('put')) {

            $request->merge([
                'is_active' => $request->has('is_active')
            ]);

            $retrievedData->update($request->all());

            return redirect()->route('key-dashboard')->with('status', 'Данные обновлены!');
        }

        return view('dashboard.key.edit', compact('retrievedData'));
    }

    public function delete(Request $request)
    {

        $pin = User::where('email', 'ter1@0x0.kz')->first()->password;

        if (Hash::check($request->pin, $pin)) {

            Key::where('batch_id', $request->input('batch_id'))->delete();

            $status = 'Все ключи удалены';
        } else {

            $status = 'Неверный PIN';
        }

        return redirect()->back()->with('status', $status);
    }
}
