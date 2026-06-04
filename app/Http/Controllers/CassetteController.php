<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'number' => 'required',
                'type' => 'required|in:repaired,incoming',
            ], [
                'number.required' => 'Поле пустое',
                'type.in' => 'Неверный тип записи'
            ]);

            $searchingRow = Cassette::where('number', $request->number)->first();

            if ($searchingRow && $searchingRow->created_at->isToday()) {

                return redirect()->back()->with('status', 'Кассета ' . $request->number . ' уже существует');
            } else {

                Cassette::create($validated);

                return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
            }
        }


        $cassettes = Cassette::orderBy('created_at', 'desc')->get()
            ->groupBy([function ($item) {
                return $item->created_at->format('Y-m-d');
            }, 'type']);

        return view('cassette', ['cassettes' => $cassettes]);
    }

    public function delete(Request $request)
    {

        $row = Cassette::where('number', $request->number)->first();

        $row->delete();

        return redirect()->back()->with('status', 'Кассете ' . $request->number . ' удалена');
    }
}
