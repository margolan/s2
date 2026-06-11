<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function index(Request $request)
    {


        if ($request->isMethod('post')) {

            $searchingRow = Cassette::where('number', $request->number)->orderBy('created_at', 'desc')->get();

            $validated = $request->validate([
                'number' => 'required',
                'type' => 'required|in:repaired,incoming',
            ], [
                'number.required' => 'Поле пустое',
                'type.in' => 'Неверный тип записи'
            ]);


            if ($searchingRow->isNotEmpty()) {

                if ($searchingRow->first()->created_at->format('Y-m-d') !== now()->format('Y-m-d')) {

                    $validated['var1'] = $searchingRow->first()->created_at->format('d.m.Y');

                    Cassette::create($validated);

                    return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
                } else {

                    return redirect()->back()->with('status', 'Кассета ' . $request->number . ' уже существует');
                }
            } else {

                Cassette::create($validated);

                return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
            }
        }


        $startPerion = now()->subMonth();

        $endPerion = now()->endOfDay();

        $cassettes = Cassette::whereBetween('created_at', [$startPerion, $endPerion])->orderBy('created_at', 'desc')->get()
            ->groupBy([function ($item) {
                return $item->created_at->format('Y-m-d');
            }, 'type']);

        $report = 0;

        foreach ($cassettes->pluck('incoming') as $cassette) {
            foreach ($cassette ?? [] as $item) {
                $report += $item->number ?? 0;
            }
        }

        return view('cassette', compact('cassettes', 'report', 'startPerion', 'endPerion'));
    }

    public function delete(Request $request)
    {

        $row = Cassette::where('id', $request->id)->first();

        $row->delete();

        return redirect()->back()->with('status', 'Кассете ' . $request->number . ' удалена');
    }
}
