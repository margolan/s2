<div>

  {{-- @dump($todaysStaff) --}}

  <div class="flex items-center">
    @isset($nextMonthSchedule)
      @if ($nextMonthSchedule->isNotEmpty())
        <h2 class="border-l-4 border-orange-500 rounded-sm semibold text-4xl px-3">
          @if ($month['isFuture'])
            {{ Str::upper($month['next']->translatedFormat('F Y')) }}
          @else
            {{ Str::upper($month['current']->translatedFormat('F Y')) }}
          @endif
        </h2>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
          <path fill-rule="evenodd"
            d="M15.28 9.47a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L13.69 10 9.97 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25ZM6.03 5.22l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L8.69 10 4.97 6.28a.75.75 0 0 1 1.06-1.06Z"
            clip-rule="evenodd" />
        </svg>
        @if ($month['isFuture'])
          <h3 class="px-1 hover:text-rose-500">
            <a href="{{ request()->url() }}"
              class="underline underline-offset-3">{{ Str::upper($month['current']->translatedFormat('F')) }}</a>
          @else
            <h3 class="px-1 hover:text-rose-500"><a
                href="?y={{ $nextMonthSchedule->first()->first()->year }}&m={{ $nextMonthSchedule->first()->first()->month }}"
                class="underline underline-offset-3">
                {{ Str::upper($month['next']->translatedFormat('F')) }}
              </a>
            </h3>
        @endif
      @else
        <h2 class="border-l-4 border-orange-500 rounded-sm semibold text-4xl px-3">
          {{ Str::upper($month['current']->translatedFormat('F Y')) }}
        </h2>
      @endif
    @endisset
  </div>


  @foreach ($requestedSchedule as $index => $depart)
    <div class="py-4 mb-5 cursor-default">
      <div class="flex py-3">
        <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
            class="size-6">
            <path fill-rule="evenodd"
              d="M11 4V3a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v1H4a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1ZM9 2.5H7a.5.5 0 0 0-.5.5v1h3V3a.5.5 0 0 0-.5-.5ZM9 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"
              clip-rule="evenodd" />
            <path d="M3 11.83V12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-.17c-.313.11-.65.17-1 .17H4c-.35 0-.687-.06-1-.17Z" />
          </svg>
        </div>
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 px-1">{{ Str::upper($index) }}</h2>
      </div>


      <div class="max-w-max flex flex-wrap flex-col text-sm mb-4 gap-y-2 bg-gray-900 py-3 px-4 rounded-lg">
        @foreach ($todaysStaff[$index] as $workTypeIndex => $workType)
          @if ($workTypeIndex === 'working')
            <div class="flex flex-wrap items-center gap-2">
              <span
                class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-400 mr-1">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                На работе:
              </span>
              @foreach ($workType as $worker)
                <span
                  class="px-2.5 py-1 bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 rounded-lg text-xs font-medium">
                  {{ $worker }}
                </span>
              @endforeach
            </div>
          @else
            <div class="flex flex-wrap items-center gap-2">
              <span
                class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-amber-400 mr-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Дежурные:
              </span>
              @foreach ($workType as $worker)
                <span
                  class="px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20 rounded-lg text-xs font-medium shadow-sm shadow-amber-500/5">
                  {{ $worker }}
                </span>
              @endforeach
            </div>
          @endif
        @endforeach
      </div>


      <div class="WRAP SCHEDULE max-w-max text-sm flex text-gray-300 p-3 rounded-lg border border-gray-500 bg-gray-800"
        x-data="{ hoverIndex: null }">
        <div class="NAMES w-max flex flex-col">
          <div class="px-3 h-14 flex items-center">Имя</div>
          @foreach ($depart as $item)
            <div class="px-3 py-1 text-gray-300 even:bg-gray-700 ">
              {{ explode(' ', $item['worker_name'])[1] }}
            </div>
          @endforeach
        </div>
        <div class="DATA flex flex-col overflow-x-auto">
          <div class="h-14">
            <div class="ROW ROW_DATE w-max flex">
              @foreach ($calendar as $index => $item)
                <div
                  class="CELL w-7 py-1 text-gray-300 font-mono flex justify-center {{ $index + 1 === $today ? 'border-x-2 border-red-500 shadow-[0_0_10px] shadow-red-500' : '' }} {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-gray-700/50': hoverIndex === {{ $index }} }">
                  {{ $item['date'] }}</div>
              @endforeach
            </div>
            <div class="ROW ROW_DOW w-max flex">
              @foreach ($calendar as $index => $item)
                <div
                  class="CELL w-7 py-1 text-gray-300 uppercase font-mono flex justify-center {{ $index + 1 === $today ? 'border-x-2 border-red-500 shadow-[0_0_10px] shadow-red-500' : '' }} {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-gray-700/50': hoverIndex === {{ $index }} }">
                  {{ $item['dow'] }}</div>
              @endforeach
            </div>
          </div>
          @foreach ($depart as $item)
            <div class="ROW ROW_DATA w-max flex even:bg-gray-700">
              @foreach ($item['schedule_data'] as $index => $day)
                <div
                  class="CELL w-7 py-1 flex justify-center 
                  {{ $index }} {{ $today }}
                        {{ $index + 1 === $today ? ' border-x-2 border-red-500 shadow-[0_0_10px] shadow-red-500 rounded-none' : '' }}
                        {{ $day === 'O' ? 'text-gray-400' : '' }}
                        {{ $day === '?' ? 'text-gray-400' : '' }}
                        {{ $day === '+' ? 'text-emerald-400' : '' }}
                        {{ $day === 'D' ? 'bg-orange-400/10 text-orange-400 rounded-lg' : '' }}
                        {{ $calendar[$index]['is_weekend'] ? 'bg-red-500/10' : '' }}"
                  @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
                  :class="{ 'bg-gray-700/50': hoverIndex === {{ $index }} }">
                  {{ $day }}</div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>


      <div class="max-w-max flex gap-3 text-sm px-4 py-2 flex-wrap bg-gray-900 mt-3 rounded-lg mb-10">
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-gray-700 text-center text-emerald-400 rounded-sm">+</div> Рабочий день
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-gray-700 text-center text-gray-200 rounded-sm">О</div> Отпуск
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-gray-700 text-center text-white rounded-sm">-</div> Выходной день
        </div>
        <div class="w-max flex gap-1">
          <div class="w-6 h-5 bg-orange-500/30 text-center text-orange-400 rounded-sm">D</div> Дежурство
        </div>
      </div>

      @if (!$loop->last)
        <hr>
      @endif

    </div>
  @endforeach
</div>
