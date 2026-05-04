<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>График работ</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased dark:bg-gray-900 dark:text-white">

  <div class="HEAD h-14 flex items-center justify-between px-3">
    <h1 class="text-xl">
      <a href="/grafik" class="">График работ</a>
    </h1>

    <div class="">
      <form action="{{ route('schedule-settings') }}" method="post">
        @csrf
        <button name="depart" value="pos" @class(['text-red-500' => $settings['grafik']['pos'] ?? false])>POS</button>
        <button name="depart" value="ter" @class(['text-red-500' => $settings['grafik']['ter'] ?? false])>TER</button>
      </form>
    </div>
  </div>

  <div class="MAIN border border-white py-5">
    @if ($settings['grafik']['pos'])
      <p>Content for POS</p>
    @endif
    @if ($settings['grafik']['ter'])
      <p>Content for TER</p>
    @endif
  </div>

  <div>
    <p>Session</p>
    @if (session('status'))
      {{ session('status') }}
    @endif
  </div>

  {{-- @if ($settings)
    @dump($settings)
  @endif --}}


</body>

</html>
