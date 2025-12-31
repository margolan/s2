<?php

// ======================== Import ==========================

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use App\Models\ScheduleWorker;
use App\Models\ScheduleDate;
use App\Models\ScheduleDay;
use Carbon\Carbon;

class ScheduleImport implements ToCollection, WithEvents
{
  protected $month;
  protected $year;

  public function __construct($month, $year)
  {
    $this->month = $month;
    $this->year = $year;
  }

  public function collection(Collection $rows)
  {
    // Здесь не обрабатываем — всё в AfterSheet
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {
        $sheet = $event->sheet->getDelegate();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $workers = [];
        $dataStartColumn = 'E'; // Пример, где начинаются дни (отрегулируй по файлу)
        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;

        // Находим строки с "сервис инженер"
        for ($row = 1; $row <= $highestRow; $row++) {
          $cellValue = $sheet->getCell('B' . $row)->getValue(); // Столбец B — сервис инженер
          if (stripos($cellValue, 'сервис инженер') !== false) {
            $nameColumn = 'A'; // Слева имя
            $name = $sheet->getCell($nameColumn . $row)->getValue();
            $name = trim(preg_replace('/\s+/', ' ', $name)); // Нормализация

            $workerData = [];
            $currentColumn = $sheet->getColumnIterator($dataStartColumn); // Пропускаем 1 колонку
            $currentColumn->next(); // Пропуск одной колонки

            for ($day = 1; $day <= $daysInMonth; $day++) {
              if (!$currentColumn->valid()) break;
              $col = $currentColumn->current()->getColumn();
              $cell = $sheet->getCell($col . $row);
              $value = $cell->getCalculatedValue(); // Вычисляем формулу

              $status = '-'; // По умолчанию выходной
              if (stripos($value, '8:00') !== false || preg_match('/=ЕСЛИ\(/i', $cell->getValue())) {
                $status = '+'; // Рабочий
              } elseif (stripos($value, '12:00') !== false) {
                $status = 'D'; // Дежурство
              } elseif (stripos($value, 'O') !== false) {
                $status = 'O'; // Отпуск
              } elseif (stripos($value, 'B') !== false || empty($value)) {
                $status = '-'; // Выходной
              }

              $workerData[$day] = $status;
              $currentColumn->next();
            }

            $workers[] = ['name' => $name, 'data' => $workerData];
          }
        }

        // Сохранение в БД
        foreach ($workers as $workerInfo) {
          $worker = ScheduleWorker::firstOrCreate([
            'full_name' => $workerInfo['name'],
            'city' => 'Актобе', // Из формы или файла
            'depart' => 'Сервис инженер', // Из файла или формы
          ]);

          $date = ScheduleDate::firstOrCreate([
            'worker_id' => $worker->id,
            'year' => $this->year,
            'month' => $this->month,
          ]);

          foreach ($workerInfo['data'] as $day => $status) {
            ScheduleDay::updateOrCreate([
              'date_id' => $date->id,
              'day' => $day,
            ], [
              'status' => $status,
            ]);
          }
        }
      },
    ];
  }
}


// ======================== Controller ==========================


public function import(Request $request)
{
    $request->validate(['file' => 'required|file|mimes:xlsx']);

    Excel::import(new ScheduleImport($request->month, $request->year), $request->file('file'));

    return redirect()->back()->with('success', 'Импорт завершён');
}