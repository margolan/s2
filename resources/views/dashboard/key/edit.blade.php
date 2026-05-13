<x-app-layout>
  <x-slot name="header">
    <div class="flex">
      @include('dashboard.element.navbar')
    </div>
  </x-slot>


  {{-- @dd($data) --}}

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
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

          {{-- ======================================= [ KEY EDIT FORM ] ======================================= --}}


          <hr class="my-5">


          <div class="max-w-lg text-sm">
            <form action="{{ route('key-edit') }}" method="post"
              class="flex flex-col border border-red-500 px-3 py-5 gap-1">

              @csrf

              <label for="device_serial"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Серийный номер</label>
              <input type="text" name="device_serial" value="{{ $retrievedData->device_serial }}" class="text-sm">

              <label for="reg_number"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Номер PT</label>
              <input type="text" name="reg_number" value="{{ $retrievedData->reg_number }}" class="text-sm">

              <label for="device_id"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Номер ID</label>
              <input type="text" name="device_id" value="{{ $retrievedData->device_id }}" class="text-sm">

              <label for="device_address"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Адрес</label>
              <input type="text" name="device_address" value="{{ $retrievedData->device_address }}" class="text-sm">

              <label for="district"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Район</label>
              <select name="district" class="text-sm">
                <option value="ct" @selected($retrievedData->district == 'ct')>Город</option>
                <option value="8" @selected($retrievedData->district == '8')>8 мкр</option>
                <option value="11" @selected($retrievedData->district == '11')>11 мкр</option>
                <option value="12" @selected($retrievedData->district == '12')>12 мкр</option>
                <option value="old" @selected($retrievedData->district == 'old')>Старый город</option>
                <option value="far" @selected($retrievedData->district == 'far')>Дальний</option>
              </select>

              <label for="color"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Цвет</label>
              <select name="color" class="text-sm">
                <option value="черный" @selected($retrievedData->color == 'черный')>Черный</option>
                <option value="синий" @selected($retrievedData->color == 'синий')>Синий</option>
                <option value="желтый" @selected($retrievedData->color == 'желтый')>Желтый</option>
                <option value="красный" @selected($retrievedData->color == 'красный')>Красный</option>
              </select>

              <label for="model_name"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Модель</label>
              <input type="text" name="model_name" value="{{ $retrievedData->model_name }}">

              <label for="os_version"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Операционная
                система</label>
              <input type="text" name="os_version" value="{{ $retrievedData->os_version }}">

              <label for="ip_address" class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">IP
                адрес</label>
              <input type="text" name="ip_address" value="{{ $retrievedData->ip_address }}">

              <label for="sim_number"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Номер SIM</label>
              <input type="text" name="sim_number" value="{{ $retrievedData->sim_number }}">

              <label for="note"
                class="w-max px-2 py-1 rounded-lg text-xs translate-y-4 translate-x-2 bg-white">Коментарий</label>
              <textarea name="note"cols="30" rows="10">{{ $retrievedData->note }}</textarea>

              <div class="flex py-3 items-center gap-2"><label for="is_active">Терминал активен </label>
                <input type="checkbox" name="is_active" @checked($retrievedData->is_active)>
              </div>
            </form>
          </div>


          {{-- @dump($retrievedData) --}}

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
