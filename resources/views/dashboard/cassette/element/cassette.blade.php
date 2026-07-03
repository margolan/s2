<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-200 leading-tight">
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

  
  {{-- ======================================= [ NOTIFICATION ] ======================================= --}}


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-gray-800 shadow-xs sm:rounded-lg ">
        <div class="p-6 text-gray-100">


          <div class="max-w-4xl my-8 px-4">

            <div class="flex items-center justify-between mb-6">
              <h1 class="text-2xl font-bold">Редактирование кассеты</h1>
              <a href="{{ route('cassette.dashboard') }}"
                class="text-sm font-medium hover:text-gray-400 transition-colors">
                &larr; Назад к списку
              </a>
            </div>

            <form action="{{ route('cassette.update', $cassette) }}" method="POST"
              class="border border-gray-200 rounded-xl shadow-sm overflow-hidden">
              @csrf
              @method('PUT')

              <div class="p-6 space-y-6">

                <div>
                  <h3 class="text-lg font-medium border-b border-gray-100 pb-2 mb-4">Основная информация
                  </h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                      <label for="number" class="block text-sm font-medium mb-1">Номер</label>
                      <input type="text" name="number" value="{{ old('number', $cassette['number']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="type" class="block text-sm font-medium mb-1">Тип данных</label>

                      <select name="type"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                        <option value="repaired" {{ old('type', $cassette['type']) == 'repaired' ? 'selected' : '' }}>
                          Repaired
                        </option>
                        <option value="incoming" {{ old('type', $cassette['type']) == 'incoming' ? 'selected' : '' }}>
                          Incoming
                        </option>
                      </select>

                    </div>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-medium border-b border-gray-100 pb-2 mb-4">Дополнительно
                  </h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                      <label for="var1" class="block text-sm font-medium mb-1">Повтор от</label>
                      <input type="text" name="var1" value="{{ old('var1', $cassette['var1']) }}" disabled
                        class="w-full text-black bg-neutral-400 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="var2" class="block text-sm font-medium mb-1">VAR2</label>
                      <input type="text" name="var2" value="{{ old('var2', $cassette['var2']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="var3" class="block text-sm font-medium mb-1">VAR3</label>
                      <input type="text" name="var3" value="{{ old('var3', $cassette['var3']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                  </div>
                </div>

              </div>

              <div class="px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('cassette.dashboard') }}"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors">
                  Отмена
                </a>
                <button type="submit"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors cursor-pointer">
                  Сохранить изменения
                </button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
