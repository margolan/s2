<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Страница не найдена</title>
</head>

<body>

  <div
    class="h-screen text-gray-300 bg-neutral-950/75 bg-[url('/public/bg_index.jpg')] bg-cover bg-center bg-blend-multiply">
    <div class="w-full h-full flex justify-center flex-col items-center">
      <img src="/0x0_logo_small.png" alt="0x0"
        class="py-4 brightness-150 hover:brightness-200 duration-300 cursor-pointer mb-5">
      <p class="md:text-4xl text-2xl font-bold px-10">Страница не найдена</p>
      <p class="md:text-lg text-xs">Не удается найти запрашиваемую вами страницу</p>
      <a href="/"
        class="px-5 py-2 mt-10 bg-neutral-300 hover:bg-neutral-100 duration-300 rounded-full text-black font-bold">Домой</a>
    </div>
  </div>

</body>

</html>
