<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $request->validate([
                'number' => ['required']
            ], [
                'number.required' => 'Поле пустое'
            ]);

            $searchingRow = Cassette::where('number', $request->number)->first();

            if ($searchingRow = Cassette::where('number', $request->number)->first() && $searchingRow->created_at->format('Y-m-d') === now()->format('Y-m-d')) {

                return redirect()->back()->with('status', 'Кассета ' . $request->number . ' уже существует');
            } else {

                Cassette::create(['number' => $request->number]);

                return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
            }
        }

        $cassettes = Cassette::orderBy('id', 'desc')->get()->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        return view('cassette', ['cassettes' => $cassettes]);
    }

    public function delete(Request $request)
    {

        $row = Cassette::where('number', $request->number)->first();

        $row->delete();

        return redirect()->back()->with('status', 'Кассете ' . $request->number . ' удалена');
    }
}
