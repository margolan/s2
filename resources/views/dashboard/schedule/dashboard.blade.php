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
            <h2 class="border-l-4 border-orange-500 rounded semibold text-4xl px-3 mb-4">
              {{ Str::upper(\Carbon\Carbon::create(2026, 05)->translatedFormat('F Y')) }}</h2>
            @include('dashboard.schedule.element.table')
          @endif


          <hr class="my-5">

          <a href="{{ route('schedule-create') }}" class="w-max px-3 flex items-center"><span
              class="pr-2 text-2xl">+</span>Добавить</a>

          <hr class="my-5">

          @foreach ($allSchedules as $is_activeIndex => $is_active)
            <div class="max-w-lg pb-5">
              <p class="font-semibold text-gray-800 dark:text-gray-200">
                {{ $is_activeIndex ? 'Подтвержденные графики' : 'Неподтвержденные графики' }}</p>
              <div class="py-2">
                @foreach ($is_active as $yearIndex => $year)
                  @foreach ($year as $monthIndex => $month)
                    <div class="pl-1 flex gap-2">
                      <p class="sm:w-40 min-w-32">• {{ $yearIndex }}, {{ $monthIndex }} </p>
                      @if (!$is_activeIndex)
                        <form action="{{ route('schedule-activate') }}" method="post" class="">
                          @csrf
                          @method('put')
                          <input type="hidden" name="batch_id" value="{{ $month->first()->batch_id }}">
                          <button type="submit"
                            class="text-emerald-500 text-sm border border-emerald-500 px-2 hover:bg-emerald-500/20">Подтвердить</button>
                        </form>
                      @endif
                      <form action="{{ route('schedule-delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="batch_id" value="{{ $month->first()->batch_id }}">
                        <button type="submit"
                          class="text-red-500 text-sm border border-red-500 px-2 hover:bg-red-500/20">Удалить</button>
                      </form>
                    </div>
                  @endforeach
                @endforeach
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
