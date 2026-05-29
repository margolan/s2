<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>www.0x0.kz</title>
</head>

<body class="dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover">


  <div class="sm:h-screen">
    <div class="w-full h-full dark:bg-neutral-900/50 flex justify-center items-center">
      <div class="sm:w-180 w-160 shadow-lg mx-3 my-10 md:m-0 shadow-black flex flex-col sm:flex-row rounded-2xl overflow-hidden">


        <div class="sm:min-w-68 sm:h-auto h-100 relative">
          <div class="w-10 h-10 bg-black/50 rounded-br-2xl flex justify-center items-center absolute z-10">
            <a href="{{ route('index') }}"
              class="font-mono text-2xl cursor-pointer hover:text-teal-400 transition-colors">&lt;</a>
          </div>
          <div class="h-full bg-[url('/public/person.jpg')] bg-center bg-cover bg-no-repeat grayscale-75"></div>
        </div>


        <div class="px-7 py-10 bg-neutral-800/90">

          <h1 class="text-4xl font-semibold pb-4">Маргулан К.</h1>

          <div class="font-semibold py-3">Веб-разработчик
            <ul class="list-disc pl-5 text-neutral-400">
              <li> Увлечён развитием в back-end разработке. Ищу динамичную
                команду, где смогу совершенствовать свои навыки и вносить вклад в успех компании.</li>
            </ul>
          </div>


          <div class="font-semibold py-3">Технический стек:
            <ul class="list-disc pl-5 text-neutral-400">
              <li>Среды: PHP, JavaScript, HTML, CSS</li>
              <li>Фреймворки: Laravel, Tailwind CSS, Bootstrap</li>
              <li>Базы данных: PostgreSQL, SQlite</li>
              <li>Инструменты: Git, Composer, NPM, Vite</li>
              <li>Стандарты: MVC, REST API, PSR-4</li>
            </ul>
          </div>

          <div class="font-semibold py-3">Резюме:
            <ul class="list-disc pl-5 text-neutral-400">
              <li><a href="https://aktobe.hh.kz/applicant/resumes/view?resume=8caa6c69ff01f0a1860039ed1f4533597a4b74"
                  class="hover:text-teal-400 transition-colors">hh.kz</a>
              </li>
            </ul>
          </div>

        </div>




      </div>
    </div>
  </div>


</body>

</html>
