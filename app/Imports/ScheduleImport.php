<?php

namespace App\Imports;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ScheduleImport
{
    /**
     * Основной метод импорта
     */
    public function store($spreadsheet, $request, $city, $depart)
    {
        $sheet = $spreadsheet->getActiveSheet();

        // Входные данные из формы
        $month = (int)$request->input('month');
        $year = (int)$request->input('year');
        $batch_id = Str::uuid();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $foundSchedules = [];

        // 1. Поиск анкеров (ограничиваем поиск 500 строками для защиты сервера)
        $anchors = [];
        foreach ($sheet->getRowIterator(1, 500) as $rowIndex => $row) {
            // Проверяем только первые 10 колонок, чтобы не сканировать пустоту справа
            foreach ($row->getCellIterator('A', 'J') as $cell) {
                if (mb_strtolower($this->getCellValue($cell)) === 'сервис инженер') {
                    $anchors[] = $rowIndex;
                    break;
                }
            }
        }

        if (empty($anchors)) {
            return "Сервис инженеры не найдены. Проверьте наличие фразы 'сервис инженер'.";
        }

        // 2. Сбор данных на основе найденных анкеров
        foreach ($anchors as $anchorRow) {
            // Имя сотрудника всегда в колонке B
            $workerName = $this->getCellValue($sheet->getCell('B' . $anchorRow));

            $monthlyStatuses = [];

            // Проходим по дням месяца (начинаем с колонки E, которая 5-я по счету)
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $columnLetter = Coordinate::stringFromColumnIndex($day + 4);

                // Берем текущую ячейку (часы) и ячейку под ней (начало работы)
                $cellHours = $sheet->getCell($columnLetter . $anchorRow);
                $cellStart = $sheet->getCell($columnLetter . ($anchorRow + 1));

                $monthlyStatuses[] = $this->determineStatus($cellHours, $cellStart, $sheet);
            }

            // Формируем запись для базы данных
            $foundSchedules[] = [
                'worker_name'   => $workerName,
                'city'          => $city,
                'depart'        => $depart,
                'month'         => $month,
                'year'          => $year,
                'schedule_data' => $monthlyStatuses, // Благодаря Cast в модели, станет JSON автоматически
                'is_active'     => false,
                'batch_id'      => $batch_id,
            ];
        }

        // 3. Массовое сохранение в базу (чтобы не делать много запросов)
        foreach ($foundSchedules as $data) {
            Schedule::create($data);
        }

        return $foundSchedules; // Возвращаем данные для превью во вьюхе
    }

    /**
     * Логика определения статуса (Работа, Дежурство, Выходной...)
     */
    private function determineStatus($cellHours, $cellStart, $sheet)
    {
        $hours = $this->getCellValue($cellHours);
        $start = $this->getCellValue($cellStart);

        // 1. Проверка на Дежурство (Твоя главная закономерность)
        if ($hours == '8:00' && $start == '12:00') {
            return 'D';
        }

        // 2. Проверка по цвету (Оставляем как резерв)
        // $color = $sheet->getStyle($cellHours->getCoordinate())->getFill()->getStartColor()->getRGB();
        // if ($color === 'FFC000') {
        //     return 'D';
        // }

        // 3. Проверка на стандартную работу
        if ($hours == '8:00' && $start == '9:00') {
            return '+';
        }

        // 4. Проверка на Отпуск или Выходной через регулярки
        if (preg_match('/[ОоOo]/u', $hours)) return 'O';
        if (preg_match('/[ВвBb]/u', $hours)) return '-';

        // Если ничего не подошло, возвращаем исходное значение (или пустую строку)
        return $hours ?? '?';
    }

    /**
     * Помощник для получения чистого текста из ячейки
     */
    private function getCellValue($cell)
    {
        $value = $cell->getValue();
        if ($value instanceof RichText) {
            return $value->getPlainText();
        }
        return $value;
    }
}
