<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function dashboard(Request $request)
    {


        if ($request->isMethod('post')) {

            $searchingRow = Cassette::where('number', $request->number)->orderBy('created_at', 'desc')->get();

            $validated = $request->validate([
                'number' => [
                    'required',
                    'required_if:type,incoming',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('type') === 'incoming' && !is_numeric($value)) {
                            $fail('При выборе второй опции поле должно содержать только цифры.');
                        }
                    }
                ],
                'type' => 'required|in:repaired,incoming',
            ], [
                'number.required' => 'Поле пустое',
                'type.in' => 'Неверный тип записи'
            ]);


            if ($searchingRow->isNotEmpty() && ($searchingRow->first()->type === 'repaired')) {  // if cassette already WAS past 30 days

                if ($searchingRow->first()->created_at->format('Y-m-d') !== now()->format('Y-m-d')) {   // if cassette was earlier than today

                    $validated['var1'] = $searchingRow->first()->created_at->format('d.m.Y');

                    Cassette::create($validated);

                    return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
                } else {

                    return redirect()->back()->with('status', 'Кассета ' . $request->number . ' уже существует');
                }
            } else {

                Cassette::create($validated);

                if ($request->type === 'repaired') {

                    $reply = 'Кассета ' . $request->number . ' добавлена';
                } else {

                    $reply = 'Приход ' . $request->number . ' добавлен';
                };

                return redirect()->back()->with('status', $reply);
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

        // ===================== CALENDAR =====================

        $today = Carbon::create(2026, 05, 24);

        $startDate = $today->copy()->startOfMonth()->startOfWeek();

        $endDate = $today->copy()->endOfMonth()->endOfWeek();

        $calendar = [];

        while($startDate->lte($endDate)) {

            $calendar[$startDate->weekOfYear()][] = [
                'date' => $startDate->format('d'),
                'tableIndex' => $startDate->dayOfWeekIso,
                'isCurrentMonth' => $startDate->month === $today->month,
                'isWeekEnd' =>  $startDate->isWeekend(),
            ];

            $startDate->addDay();
        }

        // ===================== END CALENDAR =====================

        return view('dashboard.cassette.dashboard', compact('cassettes', 'report', 'startPerion', 'endPerion', 'calendar'));
    }

    public function delete(Request $request)
    {

        $row = Cassette::where('id', $request->id)->first();

        $row->delete();

        if ($row->type === 'repaired') {

            $reply = 'Кассета ' . $row->number . ' удалена';
        } else {

            $reply = 'Приход ' . $row->number . ' удален';
        }

        return redirect()->back()->with('status', $reply);
    }
}
