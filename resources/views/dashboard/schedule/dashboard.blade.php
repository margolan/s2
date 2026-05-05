<x-app-layout>
  <x-slot name="header">
    <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1">График работ</h1>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

          {{-- ======================================= [ NOTIFICATION start ] ======================================= --}}

          @if ($errors->any())
            <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
                @click="show = false">&#215;</div>
            </div>
          @endif

          @if (session('status'))
            <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
                <p>{{ session('status') }}</p>
              </div>
              <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
                @click="show = false">&#215;</div>
            </div>
          @endif

          {{-- ======================================= [ NOTIFICATION end ] ======================================= --}}


          @if ($actualSchedule->isEmpty())
            <p>График на текущий месяц пока не добавлен или не выбран</p>
          @else
            <div class="flex py-5">
              <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                  fill="currentColor" class="size-4">
                  <path
                    d="M5.75 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM5 10.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM10.25 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM7.25 8.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM8 9.5A.75.75 0 1 0 8 11a.75.75 0 0 0 0-1.5Z" />
                  <path fill-rule="evenodd"
                    d="M4.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-5V1.75A.75.75 0 0 0 4.75 1ZM3.5 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4.5a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7Z"
                    clip-rule="evenodd" />
                </svg></div>
              <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1">
                Актуальный график</h1>
            </div>
            <h2 class="border-l-4 border-orange-500 rounded semibold text-4xl px-3">
              {{ Str::upper(\Carbon\Carbon::create(2026, 05)->translatedFormat('F Y')) }}</h2>
            @include('dashboard.schedule.element.table')
          @endif


          <hr class="my-5">


          @if ($allSchedules->isEmpty())
            <p>Графики отсутствуют</p>
          @else
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
          @endif


          <hr class="my-5">


          <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1 py-4">Добавить график</h1>
          <form action="{{ route('schedule-store') }}" enctype="multipart/form-data" method="POST"
            class="max-w-[327px] flex flex-col gap-5 dark:text-gray-800 ">
            @csrf
            <div class="flex gap-5 ">
              <select name="month">
                @foreach ($formData['months'] as $value => $name)
                  <option value="{{ $value }}" @selected($formData['currentMonth'] == $value)>
                    {{ $name }}
                  </option>
                @endforeach
              </select>

              <select name="year">
                @foreach ($formData['years'] as $year)
                  <option value="{{ $year }}" @selected($formData['currentYear'] == $year)>
                    {{ $year }}
                  </option>
                @endforeach
              </select>
            </div>
            <input type="file" class="custom-file-input w-max text-gray-200" name="file">
            <input type="submit" value="Отправить"
              class="w-max bg-white px-3 h-[42px] cursor-pointer border border-gray-800 mr-5">
          </form>



        </div>
      </div>
    </div>
  </div>
</x-app-layout>
