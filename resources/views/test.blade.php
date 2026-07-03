<x-layout>
  <x-slot:title>0x0 Core</x-slot:title>


  {{-- LOGIN / LOGOUT --}}

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

  {{-- LOGIN / LOGOUT --}}

  <div class="h-screen text-gray-300 bg-black/50 bg-[url(/public/bg_index.jpg)] bg-center bg-cover bg-blend-overlay">
    <div class="w-full h-full flex justify-center items-center">
      <div class="w-2xl px-5 py-10 backdrop-blur rounded-lg">

        <div class="flex items-center gap-3">
          <img src="/0x0_logo_small.png" alt="0x0"
            class="w-20 py-4 animate-pulse brightness-200 hover:animate-none cursor-pointer">
          <span class="w-1 h-12 border-l-3 border-neutral-300"></span>
          <h1 class="tracking-wider text-3xl py-3">CORE</h1>
        </div>

        <p class="py-8">Привет. Я Маргулан, и это ядро моих проектов на Laravel. Если вы ищете конкретный инструмент
          или моё
          резюме — воспользуйтесь ссылками ниже.</p>

        <div class="flex gap-5 justify-normal flex-wrap">
          <p class="flex flex-nowrap">//<a href="{{ route('schedule.index') }}"
              class="text-gray-400 hover:text-blue-400 transition-colors underline underline-offset-3 pl-1"> Grafik</a>
          </p>
          <p class="flex flex-nowrap">//<a href="{{ route('key.dashboard') }}"
              class="text-gray-400 hover:text-blue-400 transition-colors underline underline-offset-3 pl-1"> Keys</a>
          </p>
          <p class="flex flex-nowrap">//<a href="{{ route('cassette.dashboard') }}"
              class="text-gray-400 hover:text-blue-400 transition-colors underline underline-offset-3 pl-1">
              Cassette</a></p>
          <p class="flex flex-nowrap">//<a href="{{ route('about') }}"
              class="text-gray-400 hover:text-blue-400 transition-colors underline underline-offset-3 pl-1">For
              HeadHunters</a></p>
        </div>
      </div>
    </div>
  </div>



</x-layout>
