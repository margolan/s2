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


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-xs sm:rounded-lg ">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          {{-- @dump($user) --}}

          <div class="max-w-4xl my-8 px-4">

            <div class="flex items-center justify-between mb-6">
              <h1 class="text-2xl font-bold">Редактирование пользователя</h1>
              <a href="{{ route('admin.dashboard') }}"
                class="text-sm font-medium hover:text-gray-900 transition-colors">
                &larr; Назад к списку
              </a>
            </div>

            <form action="{{ route('admin.user.update', $user['id']) }}" method="POST"
              class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
              @csrf
              @method('PUT')

              <div class="p-6 space-y-6">

                <div>
                  <h3 class="text-lg font-medium text-gray-900 border-b border-gray-100 pb-2 mb-4">Основная информация
                  </h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                      <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Имя / Логин</label>
                      <input type="text" id="name" name="name" value="{{ old('name', $user['name']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email адрес</label>
                      <input type="email" id="email" name="email" value="{{ old('email', $user['email']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-medium text-gray-900 border-b border-gray-100 pb-2 mb-4">Департамент и Доступ
                  </h3>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                      <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Роль (System
                        Role)</label>
                      <input type="role" id="role" name="role" value="{{ old('role', $user['role']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="depart" class="block text-sm font-medium text-gray-700 mb-1">Департамент</label>
                      <input type="text" id="depart" name="depart" value="{{ old('depart', $user['depart']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                    <div>
                      <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Город</label>
                      <input type="city" id="city" name="city" value="{{ old('city', $user['city']) }}"
                        class="w-full text-black rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3">
                    </div>

                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-medium text-gray-900 border-b border-gray-100 pb-2 mb-4">Безопасность</h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                      <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Новый пароль</label>
                      <input type="password" id="password" name="password"
                        placeholder="Оставьте пустым, если не хотите менять"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 placeholder-gray-400">
                    </div>

                    <div class="flex items-center pt-6">
                      <div class="flex items-center h-5">
                        <input type="hidden" name="active" value="0"> {{-- Костыль для отправки 0, если чекбокс снят --}}
                        <input type="checkbox" id="active" name="active" value="1"
                          {{ old('active', $user['active']) == '1' ? 'checked' : '' }}
                          class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                      </div>
                      <div class="ml-3 text-sm">
                        <label for="active" class="font-medium text-gray-700">Активный аккаунт</label>
                        <p class="text-gray-500 text-xs">Если отключено, пользователь не сможет авторизоваться в
                          системе.</p>
                      </div>
                    </div>

                  </div>
                </div>

              </div>

              <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                  Отмена
                </a>
                <button type="submit"
                  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors">
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
