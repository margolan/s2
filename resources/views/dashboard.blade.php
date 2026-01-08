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

          <ul class="flex gap-3">
            @can('create-schedule')
              <li><a href="{{ route('schedule-create') }}">Create Schedule</a></li>
            @endcan
            @can('view-users')
              <li><a href="#">View Users</a></li>
            @endcan
          </ul>


          @yield('dashboard-content')


        </div>
      </div>
    </div>
  </div>
</x-app-layout>
