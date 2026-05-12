<div>

  @php
    $bgColors = [
        'красный' => 'bg-red-500',
        'зеленый' => 'bg-green-500',
        'черный' => 'bg-black',
        'синий' => 'bg-blue-500',
        'желтый' => 'bg-yellow-500',
    ];
  @endphp

  {{-- SCROLL BUTTON --}}

  <div x-data="{ show: false }" x-on:scroll.window="show = window.pageYOffset > 500" x-show="show" x-transition
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="w-14 h-14 border bg-white fixed bottom-5 right-5 flex justify-center cursor-pointer"
    style="display: none;">
    <div class="arrow w-6 h-6 border-t-8 border-l-8 border-gray-800 rotate-45 mt-5"></div>
  </div>


  <div class="CONTENT text-sm dark:text-gray-300" x-data="{ search: '' }">

    {{-- LEGEND --}}
    
    <div class="LEGEND max-w-xl flex gap-3 bg-gray-900 p-4 items-center">
      @foreach ($report as $cityName => $count)
        <a href="#{{ $cityName }}" class="text-center">{{ $cityName }} <span
            class="text-xs">({{ $count }})</span></a>
      @endforeach
    </div>

    {{-- SEARCH --}}

    <div class="py-5">
      <input type="search" class="max-w-xl w-full bg-gray-600 text-gray-200 rounded-md"
        placeholder="Поис: адрес, PT, Q..." x-model="search">
    </div>

    {{-- TABLE --}}

    @foreach ($data as $districtIndex => $district)
      <div class="DISTRICT py-3">
        <h2 class="text-3xl" id="{{ $districtIndex }}">{{ $districtIndex }}</h2>
      </div>

      <div class="w-full overflow-x-auto mb-5">
        <div class="w-max" x-show="true">
          <div class="HEADER px-3 py-2 flex bg-gray-600 rounded-t-lg">
            <div class="w-28">РЕГ. НОМЕР</div>
            <div class="mr-3">ЦВЕТ</div>
            <div class="mr-3">АДРЕС</div>
            <div class="mr-3">РАЙОН</div>
            <div class="mr-3 text-indigo-500">IP АДРЕС</div>
            <div class="mr-3 text-yellow-500">SIM НОМЕР</div>
            <div class="mr-3 text-emerald-500">ЗАВОДСКОЙ НОМЕР</div>
          </div>

          @foreach ($district as $cell)
            <div class="CONTENT flex items-center pl-2 py-1 hover:bg-gray-700/50 odd:bg-gray-700"
              x-show="search === '' || 
                String({{ \Illuminate\Support\Js::from($cell->device_address) }}).toLowerCase().includes(search.toLowerCase()) || 
                String({{ \Illuminate\Support\Js::from($cell->reg_number) }}).toLowerCase().includes(search.toLowerCase())">
              <div class="w-3 h-3 border border-white mr-1 {{ $bgColors[$cell->color] ?? '' }}"></div>
              <div class="w-24  ">{{ $cell->reg_number }}</div>
              <div class="mr-3">{{ $cell->device_address }}</div>
              <div class="mr-3">{{ $cell->district }}</div>
              <div class="mr-3 text-indigo-500">{{ $cell->ip_address ?? 'x' }}</div>
              <div class="mr-3 text-yellow-500">{{ $cell->sim_number ?? 'x' }}</div>
              <div class="mr-3 text-emerald-500">{{ $cell->device_serial ?? 'x' }}</div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach

  </div>

</div>
