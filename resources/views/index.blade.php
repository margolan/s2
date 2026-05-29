<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>www.0x0.kz</title>
</head>

<body>


  <div class="h-screen dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover">
    <div class="w-full h-full dark:bg-neutral-900/80 flex justify-center items-center">
      <div class="w-2xl p-5 md:text-left text-center">
        <h1 class="font-mono tracking-wider text-3xl py-3">DIGITAL CORE</h1>
        <p class="py-3">Привет. Я Маргулан, и это хаб моих проектов. Если вы ищете конкретный инструмент или моё
          резюме — воспользуйтесь ссылками ниже.</p>
        <div class="flex gap-5 justify-center md:justify-normal">
          <p><a href="{{ route('schedule-index') }}" class="text-gray-400 hover:text-teal-400 transition-colors">//
              Grafik</a></p>
          <p><a href="{{ route('key-dashboard') }}" class="text-gray-400 hover:text-teal-400 transition-colors">//
              Keys</a></p>
          <p> <a href="{{ route('about') }}" class="text-gray-400 hover:text-teal-400 transition-colors">// About</a>
          </p>
        </div>
      </div>
    </div>
  </div>


</body>

</html>
