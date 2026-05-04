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

  <div
    class="CONTENT min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

    <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <h1> <a href="/grafik" class="font-semibold text-gray-800 dark:text-gray-200">График работ</a> </h1>

          <div>
            <form action="{{ route('schedule-settings') }}" method="post">
              @csrf
              <button name="depart" value="pos" @class(['text-red-500' => $settings['grafik']['pos'] ?? false])>POS</button>
              <button name="depart" value="ter" @class(['text-red-500' => $settings['grafik']['ter'] ?? false])>TER</button>
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
              <p>График на текущий месяц пока не добавлен</p>
            @else
              <h1 class="font-semibold text-gray-800 dark:text-gray-200 px-1 py-4">Актуальный график</h1>
              @include('dashboard.schedule.element.table')
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
