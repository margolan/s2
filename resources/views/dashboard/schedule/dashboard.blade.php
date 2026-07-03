<x-app-layout>
  <x-slot name="header">
    <div class="flex">
      @include('dashboard.element.navbar')
    </div>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-xs sm:rounded-lg ">
        <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

          {{-- ======================================= [ NOTIFICATION ] ======================================= --}}

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

          {{-- ======================================= [ REQUESTED SCHEDULE ] ======================================= --}}


          @if ($requestedSchedule->isEmpty())
            <p>График на текущий месяц пока не добавлен или не выбран</p>
          @else
            @include('dashboard.schedule.element.table')
          @endif


          <hr class="my-5"> {{-- ============================= [ SCHEDULES LIST ] ============================= --}}


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
                        <p class="sm:w-40 min-w-32">• {{ $yearIndex }},
                          {{ Str::ucfirst(\Carbon\Carbon::create(null, $monthIndex)->translatedFormat('F')) }}</p>
                        @if (!$is_activeIndex)
                          <form action="{{ route('schedule.activate') }}" method="post" class="">
                            @csrf
                            @method('put')
                            <input type="hidden" name="batch_id" value="{{ $month->first()->batch_id }}">
                            <button type="submit"
                              class="text-emerald-500 text-sm border border-emerald-500 px-2 hover:bg-emerald-500/20">Подтвердить</button>
                          </form>
                        @endif
                        <form action="{{ route('schedule.delete') }}" method="post">
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


          <hr class="my-5"> {{-- ============================= [ NEW SCHEDULE ADD FORM ] ============================= --}}


          <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1 py-4">Добавить график</h1>
          <form action="{{ route('schedule.store') }}" enctype="multipart/form-data" method="POST"
            class="max-w-81 flex flex-col gap-5 dark:text-gray-800">
            @csrf
            <div class="flex gap-5 ">
              <select name="month" class="text-sm">
                @foreach ($formData['months'] as $value => $name)
                  <option value="{{ $value }}" @selected($formData['currentMonth'] == $value)>
                    {{ Str::ucfirst($name) }}
                  </option>
                @endforeach
              </select>

              <select name="year" class="text-sm">
                @foreach ($formData['years'] as $year)
                  <option value="{{ $year }}" @selected($formData['currentYear'] == $year)>
                    {{ $year }}
                  </option>
                @endforeach
              </select>
            </div>
            <input type="file" class="custom-file-input w-max text-sm" name="file">
            <input type="submit" value="Отправить" class="w-max bg-white px-3 h-10 text-sm cursor-pointer border border-gray-800 mr-5">
          </form>


        </div>
      </div>
    </div>
  </div>
</x-app-layout>
