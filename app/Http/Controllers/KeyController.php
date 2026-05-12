<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Imports\KeyImport;
use App\Models\Key;
use Illuminate\Support\Str;

class KeyController extends Controller
{

    public function index()
    {
        return view('key');
    }

    public function dashboard()
    {

        $districtNames = [
            'ct' => 'Город',
            '8' => '8 мкр',
            '11' => '11 мкр',
            '12' => '12 мкр',
            'old' => 'Старый город',
            'far' => 'Районы',
        ];

        $data = Key::orderBy('id')
            ->get()
            ->groupBy('district')->mapWithKeys(function ($data, $index) use ($districtNames) {
                return [$districtNames[$index] ?? "Неизвестный район ($index)" => $data];
            });

        $report = $data->map(function ($data, $index) {
            return $data->count();
        });

        return view('dashboard.key.dashboard', compact('report'))->with('data', $data);
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

        return view('dashboard.key.dashboard')->with('data', $data);
    }
}
