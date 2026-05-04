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
            <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1 py-4">Актуальный график</h1>

            @include('dashboard.schedule.element.table')
          @endif


          <hr class="m-5">

          <a href="{{ route('schedule-create') }}" class="w-max px-3 flex items-center"><span
              class="pr-2 text-2xl">+</span>Добавить</a>

          <hr class="m-5">

          @foreach ($allSchedules as $is_activeIndex => $is_active)
            <p class="font-semibold text-gray-800 dark:text-gray-200">
              {{ $is_activeIndex ? 'Active Schedules' : 'Inactive Schedules' }}</p>
            @foreach ($is_active as $yearIndex => $year)
              <ul class="pl-7 pb-2 list-disc">
                @foreach ($year as $monthIndex => $month)
                  <li class="">
                    <p>{{ $yearIndex }}, {{ $monthIndex }} <a href="#" class="text-red-500">[удалить]</a></p>
                  </li>
                @endforeach
              </ul>
            @endforeach
          @endforeach

          <hr class="m-5">

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
