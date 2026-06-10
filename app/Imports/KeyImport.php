<?php

namespace App\Imports;

use App\Models\Key;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use Illuminate\Support\Str;

class KeyImport
{
    public function store($spreadsheet)
    {
        $sheet = $spreadsheet->getActiveSheet();
        $data = [];
        $batch_id = Str::uuid();

        foreach ($sheet->getRowIterator(1, 500) as $row) {
            $cellIterator = $row->getCellIterator('A', 'J');
            $cellIterator->setIterateOnlyExistingCells(false); // Чтобы не пропускать пустые ячейки

            $cells = [];
            foreach ($cellIterator as $index => $cell) {
                $cells[] = $this->getCellValue($cell);
            }

            if (empty(array_filter($cells))) continue;

            $data[] = [
                'reg_number'        => $cells[0] ?? null,
                'device_address'    => $cells[1] ?? null,
                'color'             => $cells[2] ?? null,
                'district'          => $cells[3] ?? null,
                'device_serial'     => $cells[4] ?? null,
                'device_id'         => $cells[5] ?? null,
                'batch_id'          => $batch_id,
            ];
        }

        foreach ($data as $data) {
            Key::create($data);
        }

        return $data;
    }

    private function getCellValue($cell)
    {
        $value = $cell->getValue();
        if ($value instanceof RichText) {
            return $value->getPlainText();
        }
        return $value;
    }
}
