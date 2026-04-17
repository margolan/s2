<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <ul class="flex text-sm gap-3 border-y py-5 border-gray-300 items-center">
            @can('view-users')
              <li><a href="{{ route('users-show') }}">Пользователи</a></li>
            @endcan
            @can('view-schedule')
              <li><a href="{{ route('schedule-show') }}">Графики</a></li>
              <li><a href="{{ route('schedule-create') }}">Создать график</a></li>
            @endcan

          </ul>


          {{-- @can('view-schedule')
              @include('dashboard.schedule.show')
          @endcan --}}

          @yield('dashboard-content')


        </div>
      </div>
    </div>
  </div>
</x-app-layout>
