<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>DIGITAL CORE</title>
</head>

<body>


  <div class="absolute p-5 right-0 cursor-pointer">
    <div>
      @if (!Auth::check())
        <a href="{{ route('login') }}" class="text-gray-400 hover:text-teal-400 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd"
              d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6Zm-5.03 4.72a.75.75 0 0 0 0 1.06l1.72 1.72H2.25a.75.75 0 0 0 0 1.5h10.94l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 0 0-1.06 0Z"
              clip-rule="evenodd" />
          </svg>
        </a>
      @else
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class="text-gray-400 hover:text-teal-400 transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
              <path fill-rule="evenodd"
                d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </form>
      @endif
    </div>
  </div>

  <div class="h-screen dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover">
    <div class="w-full h-full dark:bg-neutral-900/80 flex justify-center items-center">
      <div class="w-2xl p-5 md:text-left text-center">
        <h1 class="font-mono tracking-wider text-3xl py-3">DIGITAL CORE</h1>
        <p class="py-3">Привет. Я Маргулан, и это хаб моих проектов. Если вы ищете конкретный инструмент или моё
          резюме — воспользуйтесь ссылками ниже.</p>
        <div class="flex gap-5 justify-center md:justify-normal">
          <p>// <a href="{{ route('schedule-index') }}"
              class="text-gray-400 hover:text-teal-400 transition-colors underline underline-offset-3">Grafik</a></p>
          <p>// <a href="{{ route('key-dashboard') }}"
              class="text-gray-400 hover:text-teal-400 transition-colors underline underline-offset-3"> Keys</a></p>
          <p>// <a href="{{ route('cassette-dashboard') }}"
              class="text-gray-400 hover:text-teal-400 transition-colors underline underline-offset-3"> Cassette</a></p>
          <p>// <a href="{{ route('about') }}"
              class="text-gray-400 hover:text-teal-400 transition-colors underline underline-offset-3">For
              HeadHunters</a>
        </div>
      </div>
    </div>
  </div>


</body>

</html>
