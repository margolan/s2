<x-app-layout>
  <x-slot name="header">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
      График работ
    </h2>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">


          @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
              class="border border-red-500 p-3 flex justify-between items-center">
              <p>{{ session('status') }}</p>
              <span @click="show = false" class="font-mono cursor-pointer p-2 hover:bg-gray-100">
                &#10006;
              </span>
            </div>
          @endif


          @if ($actualSchedule->isEmpty())
            <p>График на текущий месяц пока не добавлен</p>
          @else
            <h1 class="mx-3 my-5 text-lg">Актуальный график</h1>

            <div class="WRAP SCHEDULE max-w-max text-sm flex">
              <div class="NAMES w-max flex flex-col rounded-l-xl">
                <div class="px-3 text-gray-300 h-14 flex items-center rounded-tl-xl bg-zinc-800">Имя</div>
                @foreach ($actualSchedule as $item)
                  <div class="px-3 py-1 text-gray-300 odd:bg-zinc-800 even:bg-zinc-700 last:rounded-bl-xl">
                    {{ explode(' ', $item['worker_name'])[1] }}
                  </div>
                @endforeach
              </div>
              <div class="DATA flex flex-col overflow-x-auto rounded-r-xl">
                <div class="h-14 bg-zinc-800">
                  <div class="ROW_DATE w-max flex">
                    @foreach ($calendar as $item)
                      <div
                        class="CELL w-7 py-1 text-gray-300 font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}">
                        {{ $item['date'] }}</div>
                    @endforeach
                  </div>
                  <div class="ROW_DOW w-max flex">
                    @foreach ($calendar as $item)
                      <div
                        class="CELL w-7 py-1 text-gray-300 uppercase font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}">
                        {{ $item['dow'] }}</div>
                    @endforeach
                  </div>
                </div>
                @foreach ($actualSchedule as $item)
                  <div class="ROW_DATA w-max flex odd:bg-zinc-800 even:bg-zinc-700">
                    @foreach ($item['schedule_data'] as $index => $day)
                      <div
                        class="CELL w-7 py-1 flex justify-center 
                        {{ $day === 'O' ? 'text-gray-400' : '' }}
                        {{ $day === '?' ? 'text-gray-400' : '' }}
                        {{ $day === '+' ? 'text-emerald-400' : '' }}
                        {{ $calendar[$index]['is_weekend'] ? 'text-rose-600 ' : '' }}
                        {{ $day === 'D' ? 'bg-indigo-400/10 !text-indigo-400 rounded' : '' }}">
                        {{ $day }}</div>
                    @endforeach
                  </div>
                @endforeach
              </div>
            </div>
          @endif


          <hr class="m-5">

          <a href="{{ route('schedule-create') }}" class="w-max px-3 flex items-center"><span
              class="pr-2 text-2xl">+</span>Добавить</a>

          <hr class="m-5">

          @foreach ($allSchedules as $is_activeIndex => $is_active)
            <p>{{ $is_activeIndex ? 'Active Schedules' : 'Inactive Schedules' }}</p>
            @foreach ($is_active as $yearIndex => $year)
              @foreach ($year as $monthIndex => $month)
                <p>{{ $yearIndex }}, {{ $monthIndex }}</p>
              @endforeach
            @endforeach
          @endforeach

          <hr class="m-5">

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
