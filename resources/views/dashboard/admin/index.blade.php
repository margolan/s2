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


          <p>Admin Panel</p>

          <ul class="p-5">
            <li><a href="{{route('schedule-index')}}">Schedules</a></li>
            <li><a href="{{route('schedule-create')}}">Create New Schedule</a></li>
            <li><a href="#">Link 3</a></li>
          </ul>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>