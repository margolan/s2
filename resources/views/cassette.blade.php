<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Cassette</title>
</head>

<body>

  @if (session('status'))
    <div class="w-full absolute top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition>
      <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-b-lg mr-3 gap-3">
        <p>{{ session('status') }}</p>
        <div class="w-5 h-5 flex items-center justify-center cursor-pointer rounded-full border border-orange-900"
          @click="show = false">&#215;</div>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div class="w-full absolute top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition>
      <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-b-lg mr-3 gap-3">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <div class="w-5 h-5 flex items-center justify-center cursor-pointer rounded-full border border-orange-900"
          @click="show = false">&#215;</div>
      </div>
    </div>
  @endif


  <div class="h-screen dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover">
    <div class="w-full h-full dark:bg-neutral-900/80 flex justify-center overflow-y-scroll">
      <div class="w-2xl h-max py-10 md:text-left text-center">


        <h1 class="w-max text-3xl font-semibold mx-auto my-10">КАССЕТЫ</h1>

        {{-- =================== ADD FORM =================== --}}

        <form action="{{ route('cassette-index') }}" method="post" class="flex gap-3 my-10">
          @csrf
          <input type="text" name="number" class="w-full dark:bg-neutral-600 dark:text-neutral-300 rounded-md">
          <input type="submit" value="Добавить"
            class="px-5 py-2 dark:bg-neutral-200 dark:text-neutral-800 text-sm rounded-md">
        </form>

        {{-- =================== CASSETTES LIST =================== --}}

        @if ($cassettes)

          @foreach ($cassettes as $index => $date)
            <div class="flex items-center py-2 justify-center">
              <span class="mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                  <path fill-rule="evenodd"
                    d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              {{ \Carbon\Carbon::create($index)->format('j.m.Y') }} ( {{ count($date) }} )
            </div>
            <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-5">
              <thead>
                <tr>
                  <th class="w-8 border border-gray-400 dark:border-gray-700 py-3 text-center">#</td>
                  <th class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">Номер кассеты</td>
                  <th class="w-23 border border-gray-400 dark:border-gray-700 py-3 text-center">Время</td>
                  <th class="w-22 border border-gray-400 dark:border-gray-700 py-3 text-center">Действие</td>
                </tr>
              </thead>
              @foreach ($date as $index => $item)
                <tr class="hover:bg-emerald-800/50 odd:bg-neutral-700/50">
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">{{ $loop->count - $loop->index }}</td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1">{{ $item->number }}</td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                    {{ $item->created_at->format('H:i:s') }}
                  </td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                    @if ($item->created_at->format('Y-m-d') === now()->format('Y-m-d'))
                      <form action="{{ route('cassette-delete') }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="number" value="{{ $item->number }}">
                        <input type="submit" value="Удалить">
                      </form>
                    @else
                      -
                    @endif
                  </td>
                </tr>
              @endforeach
            </table>
          @endforeach


        @endif

      </div>
    </div>
  </div>
  </div>


</body>

</html>
