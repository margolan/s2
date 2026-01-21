<?php

namespace App\Imports;

use App\Models\ScheduleDate;
use App\Models\ScheduleWorker;
use App\Models\ScheduleDay;
use Carbon\Carbon;

class ScheduleImport
{

    public function store($data, $request)
    {

        $sheet = $data->getActiveSheet();

        function getCellData($cell)
        { // checkin for rich text
            $text = $cell->getValue();
            if ($text instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                return $text->getPlainText();
            }
            return $text;
        }

        foreach ($sheet->getRowIterator() as $rowIndex => $rowValue) { // checking and collecting anchors by keywords
            $cellIterator = $rowValue->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            foreach ($cellIterator as $cell) {
                if (getCellData($cell) === 'сервис инженер') {
                    $processed_data['anchor'][] = $rowIndex;
                }
            }
        }

        if (!isset($processed_data['anchor'])) { // return if no anchors found
            return redirect()->back()->with('status', "Сервис инженеры не найдены. Проверьте таблицу на наличие записи 'сервис инженер'");
        }

        foreach ($processed_data['anchor'] as $index => $value) {

            $processed_data['names'][] = getCellData($sheet->getCell('B' . $value));

            $row = $sheet->getRowIterator($value, $value)->current();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            $cellIndexCount = 0;

            foreach ($cellIterator as $cellValue) { // processing data
                $cellIndexCount++;
                if ($cellIndexCount > 4 && $cellIndexCount < (cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year) + 5)) {

                    $cellColor = $sheet->getStyle($cellValue->getCoordinate())->getFill()->getStartColor()->getRGB();

                    if (str_contains($cellValue->getValue(), '8:00') && $cellColor === 'FFFFFF') {
                        $processed_data['data'][$index][] = '+';
                    } else if (str_contains($cellValue->getValue(), '8:00') && $cellColor === 'E6B8B8') {
                        $processed_data['data'][$index][] = '+';
                    } else if (str_contains($cellValue->getValue(), '8:00') && $cellColor === 'FFC000') {
                        $processed_data['data'][$index][] = 'D';
                    } else if (preg_match('/\p{Cyrillic}/u', $cellValue) && preg_match('/[Оо]/u', $cellValue)) {
                        $processed_data['data'][$index][] = 'O';
                    } else if (preg_match('/\p{Latin}/u', $cellValue) && preg_match('/[Oo]/u', $cellValue)) {
                        $processed_data['data'][$index][] = 'O';
                    } else if (str_contains($cellValue->getValue(), 'В')) {
                        $processed_data['data'][$index][] = '-';
                    } else {
                        $processed_data['data'][$index][] = $cellColor . ' ' . $cellValue->getValue();
                    }
                }
            }
        }

        for ($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year); $i++) { // numbers and days of the week
            $processed_data['dates']['day'][] = $i + 1;
            $processed_data['dates']['carbon'][] = Carbon::create($request->year, $request->month, $i + 1)->translatedFormat('D');
        }

        $dataToStore = [];

        foreach ($processed_data as $key => $value) {
            if (!empty($value)) {
                $dataToStore[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
        }

        $dataToStore['date'] = $request->input('month') . $request->input('year');
        $dataToStore['city'] = $request->input('city');
        $dataToStore['depart'] = $request->input('depart');

        // Schedule::create($dataToStore);

        ScheduleDate::class;
        ScheduleDay::class;
        ScheduleWorker::class;

        return $processed_data;
    }
}
