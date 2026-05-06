<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>График</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">


  {{-- ======================================= [ NOTIFICATION start ] ======================================= --}}


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


  {{-- ======================================= [ NOTIFICATION end ] ======================================= --}}


  <div class="CONTENT min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 dark:text-gray-100">

    <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <h1> <a href="/grafik" class="font-semibold text-gray-800 dark:text-gray-200">График работ</a> </h1>

          <div class="flex">
            <form action="{{ route('schedule-settings') }}" method="post" class="flex items-center gap-2">
              @csrf
              <button name="depart" value="sort" class="hover:text-rose-500 transition"><svg
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                  <path fill-rule="evenodd"
                    d="M13.836 2.477a.75.75 0 0 1 .75.75v3.182a.75.75 0 0 1-.75.75h-3.182a.75.75 0 0 1 0-1.5h1.37l-.84-.841a4.5 4.5 0 0 0-7.08.932.75.75 0 0 1-1.3-.75 6 6 0 0 1 9.44-1.242l.842.84V3.227a.75.75 0 0 1 .75-.75Zm-.911 7.5A.75.75 0 0 1 13.199 11a6 6 0 0 1-9.44 1.241l-.84-.84v1.371a.75.75 0 0 1-1.5 0V9.591a.75.75 0 0 1 .75-.75H5.35a.75.75 0 0 1 0 1.5H3.98l.841.841a4.5 4.5 0 0 0 7.08-.932.75.75 0 0 1 1.025-.273Z"
                    clip-rule="evenodd" />
                </svg></button>
              <button name="depart" value="pos" @class([
                  'text-rose-500' => $settings['grafik']['depart']['pos'] ?? false,
              ])>POS</button>
              <button name="depart" value="ter" @class([
                  'text-rose-500' => $settings['grafik']['depart']['ter'] ?? false,
              ])>TER</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
          <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

            @if ($actualSchedule->isEmpty())
              <p>График на текущий месяц пока не добавлен или не выбран</p>
            @else
              @include('dashboard.schedule.element.table')
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
