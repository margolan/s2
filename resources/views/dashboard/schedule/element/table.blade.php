<div>
  <div class="flex items-center">
    <h2 class="border-l-4 border-orange-500 rounded semibold text-4xl px-3">
      {{ Str::upper(\Carbon\Carbon::create($actualSchedule->first()->first()->year, $actualSchedule->first()->first()->month)->translatedFormat('F Y')) }}
    </h2>
    @if (!empty($nextMonth))
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
        <path fill-rule="evenodd"
          d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z"
          clip-rule="evenodd" />
      </svg>
      <h3 class="px-1 hover:text-rose-500"><a
          href="?y={{ $nextMonth->year }}&m={{ $nextMonth->month }}">{{ Str::upper(\Carbon\Carbon::create(null, $nextMonth->month)->translatedFormat('F')) }}</a>
      </h3>
    @endif
  </div>
  @foreach ($actualSchedule as $index => $depart)
    <div class="py-4 mb-5 cursor-default">
      <div class="flex py-3">
        <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
            class="size-4">
            <path fill-rule="evenodd"
              d="M11 4V3a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v1H4a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1ZM9 2.5H7a.5.5 0 0 0-.5.5v1h3V3a.5.5 0 0 0-.5-.5ZM9 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"
              clip-rule="evenodd" />
            <path d="M3 11.83V12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-.17c-.313.11-.65.17-1 .17H4c-.35 0-.687-.06-1-.17Z" />
          </svg>
        </div>
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 px-1">{{ Str::upper($index) }}</h2>
      </div>
      <div class="WRAP SCHEDULE max-w-max text-sm flex text-gray-300 p-3 bg-zinc-800 rounded-lg"
        x-data="{ hoverIndex: null }">
        <div class="NAMES w-max flex flex-col">
          <div class="px-3 h-14 flex items-center bg-zinc-800">Имя</div>
          @foreach ($depart as $item)
            <div class="px-3 py-1 text-gray-300 odd:bg-zinc-800 even:bg-zinc-700 ">
              {{ explode(' ', $item['worker_name'])[1] }}
            </div>
          @endforeach
        </div>
        <div class="DATA flex flex-col overflow-x-auto">
          <div class="h-14 bg-zinc-800">
            <div class="ROW ROW_DATE w-max flex">
              @foreach ($calendar as $index => $item)
                <div
                  class="CELL w-7 py-1 text-gray-300 font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
                  {{ $item['date'] }}</div>
              @endforeach
            </div>
            <div class="ROW ROW_DOW w-max flex">
              @foreach ($calendar as $index => $item)
                <div
                  class="CELL w-7 py-1 text-gray-300 uppercase font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
                  {{ $item['dow'] }}</div>
              @endforeach
            </div>
          </div>
          @foreach ($depart as $item)
            <div class="ROW ROW_DATA w-max flex odd:bg-zinc-800 even:bg-zinc-700">
              @foreach ($item['schedule_data'] as $index => $day)
                <div
                  class="CELL w-7 py-1 flex justify-center 
                        {{ $day === 'O' ? 'text-gray-400' : '' }}
                        {{ $day === '?' ? 'text-gray-400' : '' }}
                        {{ $day === '+' ? 'text-emerald-400' : '' }}
                        {{ $day === 'D' ? 'bg-orange-400/10 text-orange-400 rounded-lg' : '' }}
                        {{ $calendar[$index]['is_weekend'] ? 'bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
                  {{ $day }}</div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
      <div class="flex gap-2 text-sm px-3 py-2 w-full flex-wrap">
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-zinc-600 text-center text-emerald-400 rounded">+</div> - Рабочий день
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-zinc-600 text-center text-gray-200 rounded">О</div> - Отпуск
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-zinc-600 text-center text-white rounded">-</div> - Выходной день
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-orange-500/30 text-center text-orange-400 rounded">D</div> - Дежурство
        </div>
      </div>
    </div>
  @endforeach
</div>
