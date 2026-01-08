<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleImport implements ToCollection
{
    public array $result = [];
    protected ?Worksheet $worksheet = null;

    // Для чтения цвета (если понадобится)
    public function setWorksheet(Worksheet $worksheet)
    {
        $this->worksheet = $worksheet;
    }

    public function collection(Collection $rows)
    {
        $rowCount = $rows->count();

        foreach ($rows as $rowIndex => $row) {

            foreach ($row as $colIndex => $cellValue) {

                if ($this->isServiceEngineer($cellValue)) {

                    // Имя слева
                    $employeeName = $row[$colIndex - 1] ?? null;
                    if (!$employeeName) continue;

                    $dayStartCol = $colIndex + 2; // через 1 колонку

                    $days = [];

                    for ($dayCol = $dayStartCol; $dayCol < count($row); $dayCol++) {

                        $upperCell = $row[$dayCol] ?? null;
                        $lowerCell = $rows[$rowIndex + 1][$dayCol] ?? null;

                        $dayData = $this->analyzeDay($upperCell, $lowerCell, $rowIndex + 1, $dayCol + 1);

                        if ($dayData) $days[] = $dayData;
                    }

                    $this->result[] = [
                        'employee' => trim($employeeName),
                        'position' => 'сервис инженер',
                        'days' => $days,
                    ];
                }
            }
        }
    }

    private function isServiceEngineer($value): bool
    {
        if (!$value) return false;
        $value = mb_strtolower(trim($value));
        return str_contains($value, 'сервис') && str_contains($value, 'инженер');
    }

    private function analyzeDay($upper, $lower, $rowNum, $colNum): ?array
    {
        if (!$upper) return null;

        $upper = trim((string)$upper);
        $lower = trim((string)$lower);

        $upperNorm = mb_strtolower($upper);
        $lowerNorm = mb_strtolower($lower);

        // Выходной
        if (in_array($upperNorm, ['b', 'в'])) {
            return $this->dayResult('weekend', $rowNum, $colNum, true, false, false, false);
        }

        // Отпуск
        if (in_array($upperNorm, ['o', 'о'])) {
            return $this->dayResult('vacation', $rowNum, $colNum, false, false, true, false);
        }

        // Рабочий
        if ($upper == '8:00' && $lower == '9:00') {
            return $this->dayResult('work', $rowNum, $colNum, false, true, false, false);
        }

        // Дежурство
        if ($upper == '8:00' && $lower == '12:00') {
            return $this->dayResult('duty', $rowNum, $colNum, false, false, false, true);
        }

        return null;
    }

    private function dayResult(
        string $type,
        int $row,
        int $col,
        bool $isWeekend,
        bool $isWork,
        bool $isVacation,
        bool $isDuty
    ): array {
        // Цвет ячейки (если есть worksheet)
        $cellColor = null;
        if ($this->worksheet) {
            $cell = $this->worksheet->getCellByColumnAndRow($col, $row);
            $cellColor = $cell->getStyle()->getFill()->getStartColor()->getRGB();
        }

        return [
            'type' => $type,
            'is_weekend' => $isWeekend,
            'is_workday' => $isWork,
            'is_vacation' => $isVacation,
            'is_duty' => $isDuty,
            'cell_color' => $cellColor,
        ];
    }
}
