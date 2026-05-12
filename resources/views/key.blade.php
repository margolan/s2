<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Ключи</title>
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
          <h1> <a href="/grafik" class="font-semibold text-gray-800 dark:text-gray-200">Ключи</a> </h1>
          <div class="flex">
            {{-- NAVBAR --}}
          </div>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
          <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint ad enim delectus. Porro eveniet fuga earum
              impedit aut optio voluptatum. Aliquid possimus deserunt dicta necessitatibus ab eveniet et minus
              obcaecati.</p>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
