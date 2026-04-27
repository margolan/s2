<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      График работ
    </h2>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="p-6 text-gray-900 dark:text-gray-100">


          @if (session('status'))
            <p class="border border-red-500">{{ session('status') }}</p>
          @endif

          <a href="{{ route('schedule-create') }}" class="w-max px-3 flex items-center"><span
              class="pr-2 text-2xl">+</span>Добавить</a>
          <hr class="m-4">
          @foreach ($data as $year => $data)
            <div class="border border-red-500">
              <p>{{ $year }}</p>
              @foreach ($data as $month => $row)
                {{ $month }}
                <div class="border border-gray-300 p-3 my-3">
                  @foreach ($row as $item)
                    <p>
                      {{ explode(' ', $item['worker_name'])[1] }}
                      @foreach ($item['schedule_data'] as $day)
                        {{ $day }}
                      @endforeach
                      {{ $item['is_active'] ? 'true' : 'false' }}
                    </p>
                  @endforeach
                </div>
              @endforeach
            </div>
          @endforeach


          <hr class="m-4">



          {{-- @foreach ($data as $item)
            <p>
              @foreach ($item['schedule_data'] as $day)
                {{ $day }}
              @endforeach
            </p>
          @endforeach --}}



          @isset($data)
            @dump($data)
          @endisset


        </div>
      </div>
    </div>
  </div>
</x-app-layout>
