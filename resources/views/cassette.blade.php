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
    <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition x-init="setTimeout(() => show = false, 6000)">
      <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
        <p>{{ session('status') }}</p>
      </div>
      <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
        @click="show = false">&#215;</div>
    </div>
  @endif

  <div class="h-screen dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover overflow-y-scroll">
    <div class="w-full h-full dark:bg-neutral-900/80 flex justify-center">
      <div class="w-2xl p-5 md:text-left text-center">

        <h1 class="w-max text-3xl font-semibold mx-auto my-5">КАССЕТЫ</h1>

        {{-- =================== ADD FORM =================== --}}

        <form action="{{ route('cassette-index') }}" method="post" class="flex gap-3 my-10">
          @csrf
          <input type="text" name="number" class="w-full dark:bg-neutral-600 dark:text-neutral-300 rounded-md">
          <input type="submit" value="Добавить"
            class="px-5 py-2 dark:bg-neutral-200 dark:text-neutral-800 text-sm rounded-md">
        </form>

        {{-- =================== CASSETTES LIST =================== --}}

        @if ($cassettes)

          @foreach ($cassettes as $date)
            <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm my-5 py-5">
              <thead>
                <tr>
                  <th class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">ID</td>
                  <th class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">Номер кассеты</td>
                  <th class="w-23 border border-gray-400 dark:border-gray-700 py-1 text-center">Дата и время</td>
                  <th class="w-22 border border-gray-400 dark:border-gray-700 py-1 text-center">Действие</td>
                </tr>
              </thead>
              @foreach ($date as $item)
                <tr class="hover:bg-emerald-800/50 odd:bg-neutral-700/50">
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">{{ $item->id }}</td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1">{{ $item->number }}</td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">{{ $item->created_at }}
                  </td>
                  <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                    <form action="{{ route('cassette-delete') }}" method="post">
                      @method('delete')
                      @csrf
                      <input type="hidden" name="id" value="{{ $item->id }}">
                      <input type="submit" value="Удалить">
                    </form>
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
