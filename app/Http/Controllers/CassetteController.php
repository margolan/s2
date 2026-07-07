<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function dashboard(Request $request)
    {


        // =================================================================================
        // 
        //    POST REQUEST
        // 
        // =================================================================================


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

        // =================================================================================
        // 
        //    GET REQUEST
        // 
        // =================================================================================


        // ===================== PERIOD =====================


        $today = today();
        // $today = Carbon::create(2026, 05, 22); // test

        $startOfMonth = $today->startOfMonth();

        $endOfMonth = $today->copy()->endOfMonth();

        $startDate = $startOfMonth->copy()->subWeek()->startOfWeek();

        $endDate = $endOfMonth->copy()->endOfWeek();


        // ===================== FETCHING DATA FROM DB =====================


        $cassettes = Cassette::whereBetween('created_at', [$startOfMonth, $endOfMonth])->orderBy('created_at', 'desc')->get()
            ->groupBy([function ($item) {
                return $item->created_at->format('Y-m-d');
            }, 'type']);

        $report['period'] = [$startOfMonth, $endOfMonth];
        $report['incoming'] = $cassettes->pluck('incoming')->flatten()->sum('number');
        $report['repaired'] = $cassettes->pluck('repaired')->flatten()->count();



        // ===================== CREATING CALENDAR =====================


        $calendar = [];

        $calendar['data'] = Cassette::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy([function ($item) {
                return $item->created_at->format('d.m.Y');
            }, 'type']);


        while ($startDate->lte($endDate)) {

            $incomingRecords = $calendar['data'][$startDate->format('d.m.Y')]['incoming'] ?? [];

            $calendar['days'][$startDate->weekOfYear()][] = [
                'date' => $startDate->format('d.m'),
                'tableIndex' => $startDate->dayOfWeekIso,
                'isCurrentMonth' => $startDate->month === $today->month,
                'isWeekEnd' =>  $startDate->isWeekend(),
                'repaired' => count($calendar['data'][$startDate->format('d.m.Y')]['repaired'] ?? []),
                'incoming' => collect($incomingRecords)->sum('number'),
            ];

            $startDate->addDay();
        }

        $title = '0x0 | Кассеты';

        return view('dashboard.cassette.dashboard', compact('title','cassettes', 'calendar', 'report'));
    }

    public function edit(Request $request)
    {

        $cassette = Cassette::findOrFail($request->id);

        $status = 'Данные обновлены';

        return view('dashboard.cassette.element.cassette', compact('cassette'));
    }

    public function update(Request $request)
    {

        $cassette = Cassette::findOrFail($request->id);

        $validated = $request->validate([
            'number' => 'required',
            'type' => 'required',
            'var1' => 'nullable',
            'var2' => 'nullable',
            'var3' => 'nullable',
        ]);

        $cassette->update($validated);

        $status = 'Данные обновлены';

        return redirect()->route('cassette.dashboard')->with('status', $status);
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

        return redirect()->route('cassette.dashboard')->with('status', $reply);
    }
}
