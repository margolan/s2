<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use Illuminate\Http\Request;

class CassetteController extends Controller
{
    public function index(Request $request)
    {


        if ($request->isMethod('post')) {


            Cassette::create(['number' => $request->number]);

            return redirect()->back()->with('status', 'Кассета ' . $request->number . ' добавлена');
        }

        $cassettes = Cassette::orderBy('id', 'desc')->get()->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        return view('cassette')->with('cassettes', $cassettes);
    }

    public function delete(Request $request)
    {


        $row = Cassette::find((int)$request->id);

        $row->delete();

        return redirect()->back()->with('status', 'Запись о кассете ' . $request->id . ' удалена');
    }
}
