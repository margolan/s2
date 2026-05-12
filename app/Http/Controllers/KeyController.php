<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Imports\KeyImport;
use App\Models\Key;

class KeyController extends Controller
{

    public function index()
    {
        return view('key');
    }

    public function dashboard()
    {

        $data = Key::where('is_active', true)
        ->orderBy('id')
        ->get();

        return view('dashboard.key.dashboard')->with('data', $data);
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
