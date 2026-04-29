<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
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

          <hr class="m-5">

            @dump($test)

          <hr class="m-5">

          <div class="WRAP max-w-max border border-red-500 text-sm flex">
            <div class="NAMES w-24 flex flex-col">
              <div class="px-2 h-10">Имя</div>
              @foreach ($actualSchedule as $item)
                <div class="px-2">
                  {{ explode(' ', $item['worker_name'])[1] }}
                </div>
              @endforeach
            </div>
            <div class="DATA flex flex-col overflow-x-auto">
              <div class="h-10">
                <div>{{ \Carbon\Carbon::create(null, 2) }}</div>
                <div>Lorem ipsum dolor sit amet.</div>
              </div>
              @foreach ($actualSchedule as $item)
                <div class="RAW w-max flex">
                  @foreach ($item['schedule_data'] as $day)
                    <div class="CELL w-4 flex justify-center">{{ $day }}</div>
                  @endforeach
                </div>
              @endforeach
            </div>
          </div>

          <hr class="m-5">

          <a href="{{ route('schedule-create') }}" class="w-max px-3 flex items-center"><span
              class="pr-2 text-2xl">+</span>Добавить</a>
          <hr class="m-4">
          @foreach ($allSchedules as $index => $isActive)
            <p>{{ $index ? 'Подтвержденные графики' : 'Подтвердите графики' }} </p>
            @foreach ($isActive as $year => $data)
              <div class="border border-red-500">
                @foreach ($data as $month => $row)
                  <div class="border border-purple-500" x-data="{ openMonth: false }">
                    <div class="flex">{{ Str::ucfirst($month) }}, {{ $year }}
                      <button type="submit" class="px-2 border border-gray-700"
                        @click="openMonth = !openMonth">Показать</button>
                      @if (!$index)
                        <form action="{{ route('schedule-activate') }}" method="post">
                          @csrf
                          @method('put')
                          <input type="hidden" name="batch_id" value="{{ $row[0]['batch_id'] }}">
                          <button type="submit" class="px-2 border border-gray-700">Подтвердить</button>
                        </form>
                      @endif
                      <form action="{{ route('schedule-delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="batch_id" value="{{ $row[0]['batch_id'] }}">
                        <button type="submit" class="px-2 border border-gray-700 text-red-500">Удалить</button>
                      </form>
                    </div>
                    <div class="border border-gray-300 p-3" x-show="openMonth" x-transition>
                      @foreach ($row as $item)
                        <p>
                          {{ explode(' ', $item['worker_name'])[1] }}
                          @foreach ($item['schedule_data'] as $day)
                            {{ $day }}
                          @endforeach
                        </p>
                      @endforeach
                    </div>
                  </div>
                @endforeach
              </div>
            @endforeach
          @endforeach

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
