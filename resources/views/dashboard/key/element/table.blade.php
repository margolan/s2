<div>

  {{-- @dump($data) --}}


  <div class="CONTENT text-sm dark:text-gray-300">
    @foreach ($data as $districtIndex => $district)
      <div class="text-md">
        {{ $districtIndex }}
      </div>
      <div class="border border-red-500 flex">
        <div class="w-24  border-green-500">PT</div>
        <div class=" border-green-500 mr-3">Цвет</div>
        <div class=" border-green-500 mr-3">Адрес</div>
        <div class=" border-green-500 mr-3">Район</div>
        <div class=" border-green-500 mr-3 text-indigo-500">IP адрес</div>
        <div class=" border-green-500 mr-3 text-yellow-500">SIM номер</div>
        <div class=" border-green-500 mr-3 text-emerald-500">Заводской</div>
      </div>
      @foreach ($district as $cell)
        <div class=" border-b-red-500 flex">
          <div class="w-24  border-green-500">{{ $cell->reg_number }}</div>
          <div
            class=" border-green-500 mr-3
        {{ trim($cell->color) == 'красный' ? 'text-red-500' : '' }}
        {{ trim($cell->color) == 'зеленый' ? 'text-green-500' : '' }}
        {{ trim($cell->color) == 'черный' ? 'text-black' : '' }}
        {{ trim($cell->color) == 'синий' ? 'text-blue-500' : '' }}
        {{ trim($cell->color) == 'желтый' ? 'text-yellow-500' : '' }}
         ">
            {{ $cell->color }}</div>
          <div class=" border-green-500 mr-3">{{ $cell->device_address }}</div>
          <div class=" border-green-500 mr-3">{{ $cell->district }}</div>
          <div class=" border-green-500 mr-3 text-indigo-500">{{ $cell->ip_address ?? 'x' }}</div>
          <div class=" border-green-500 mr-3 text-yellow-500">{{ $cell->sim_number ?? 'x' }}</div>
          <div class=" border-green-500 mr-3 text-emerald-500">{{ $cell->device_serial ?? 'x' }}</div>
        </div>
      @endforeach
    @endforeach

  </div>

</div>
