<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>


  {{-- ======================================= [ NOTIFICATION ] ======================================= --}}

  @if ($errors->any())
    <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition x-init="setTimeout(() => show = false, 6000)">
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



  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-xs sm:rounded-lg ">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          @dump($allSchedules)

          @if (!empty($allSchedules))
            @foreach ($allSchedules as $index => $depart)
              <div class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                <p>{{ $index }}</p>
                <ul>
                  @foreach ($depart as $index => $batch_id)
                    <li>{{ $batch_id->first()->month }}, {{ $batch_id->first()->year }} удалить </li>
                  @endforeach
                </ul>
              </div>
            @endforeach
          @endif


          <hr class="my-5"> {{-- ============================= [ NEW SCHEDULE ADD FORM ] ============================= --}}


          <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1 py-4">Добавить график</h1>
          <form action="{{ route('schedule-store') }}" enctype="multipart/form-data" method="POST"
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

              <select name="depart" class="text-sm">
                <option value="pos">Pos</option>
                <option value="ter">Ter</option>
              </select>
            </div>
            <input type="file" class="custom-file-input w-max text-sm" name="file">
            <input type="submit" value="Отправить"
              class="w-max bg-white px-3 h-10 text-sm cursor-pointer border border-gray-800 mr-5">
          </form>


          <hr class="my-5"> {{-- ============================= [ VISITORS ] ============================= --}}


          <div class="w-full my-5">
            <h1 class="font-semibold text-gray-800 dark:text-gray-200 py-4 px-2">Посетители по ресурсам</h1>
            <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm">
              <thead>
                <th class="border border-gray-300 dark:border-gray-600 px-2">URL</td>
                <th class="border border-gray-300 dark:border-gray-600 px-2">Кол-во</td>
              </thead>
              @foreach ($visitors['byResources'] as $index => $item)
                <tr>
                  <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $index }}</td>
                  <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $item }}</td>
                </tr>
              @endforeach
            </table>
          </div>


          <hr class="my-5"> {{-- ============================= [ VISITORS ] ============================= --}}


          <div x-data="{ show: false }" class="w-full my-5">
            <h1 class="font-semibold text-gray-800 dark:text-gray-200 py-4 border dark:border-gray-600 px-2"
              @click="show = !show">Посетители</h1>
            <div x-show="show" class="w-full overflow-x-scroll">
              <table class="border-collapse border border-gray-400 dark:border-gray-700 text-sm">
                <thead>
                  <tr>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">ID</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">IP</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">User</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">User Agent</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">URL</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-2">Date</th>
                  </tr>
                </thead>
                @foreach ($visitors['allRows'] as $index => $visitor)
                  <tr class="odd:bg-gray-700 hover:bg-gray-900 text-gray-300">
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->id }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->ip }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->user }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->userAgent }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->url }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-2">{{ $visitor->created_at }}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</x-app-layout>
