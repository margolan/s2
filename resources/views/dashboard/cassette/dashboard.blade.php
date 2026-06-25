<x-app-layout>


  <div id="qr-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 p-4">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-md">
      <div class="flex justify-between items-center px-4 py-3 bg-gray-100 border-b">
        <h3 class="font-semibold text-gray-800">Сканирование QR-кода</h3>
        <button type="button" onclick="closeScanner()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
      </div>
      <div class="p-4 bg-gray-50">
        <div id="scanner-preview" class="w-full aspect-square rounded-lg overflow-hidden bg-black"></div>
      </div>
    </div>
  </div>


  <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-xs sm:rounded-lg ">
        <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

          {{-- ======================================= [ NOTIFICATION ] ======================================= --}}

          @if (session('status'))
            <div class="w-full absolute top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 10000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-b-lg mr-3 gap-3">
                <p>{{ session('status') }}</p>
                <div
                  class="w-5 h-5 flex items-center justify-center cursor-pointer rounded-full border border-orange-900"
                  @click="show = false">&#215;</div>
              </div>
            </div>
          @endif



          @if ($errors->any())
            <div class="w-full absolute top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 1000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-b-lg mr-3 gap-3">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <div
                  class="w-5 h-5 flex items-center justify-center cursor-pointer rounded-full border border-orange-900"
                  @click="show = false">&#215;</div>
              </div>
            </div>
          @endif


          {{-- ======================================= [ NOTIFICATION ] ======================================= --}}




          <h1 class="w-max text-3xl font-semibold font-serif mx-auto my-10 tracking-widest">КАССЕТЫ</h1>

          {{-- =================== ADD FORM =================== --}}

          <form action="{{ route('cassette-dashboard') }}" method="post" class="flex gap-3 my-10">
            @csrf
            <select name="type" class="rounded-md text-sm dark:bg-neutral-600 dark:text-neutral-300">
              <option value="repaired">Закрытие</option>
              <option value="incoming">Приход</option>
            </select>

            <div class="w-full relative">
              <input type="text" id="qr-result" name="number"
                class="w-full dark:bg-neutral-600 dark:text-neutral-300 rounded-md" autofocus>

              <button type="button" onclick="openScanner()"
                class="text-gray-500 hover:text-blue-600 focus:outline-none absolute top-2 md:right-5 right-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </button>
            </div>

            <input type="submit" value="Добавить"
              class="px-3 py-2 dark:bg-neutral-200 dark:text-neutral-800 text-sm rounded-md">
          </form>

          <div class="text-sm my-10 flex justify-center items-center font-mono">
            <div class="py-1">
              <div class="py-1 text-right">С {{ $startPerion->format('d.m.Y') }}</div>
              <div class="py-1 text-right">По {{ $endPerion->format('d.m.Y') }}</div>
            </div>
            <div class="flex">
              <div class="text-6xl -translate-y-2 px-2">}</div>
              <div class="flex items-center -translate-y-1">{{ $report }} кассет</div>
            </div>
          </div>

          {{-- =================== CASSETTES LIST =================== --}}


          @if ($cassettes)

          @dump($test)

          {{-- @dump($cassettes) --}}

            @foreach ($cassettes as $index => $date)
              <div class="pb-10">

                <div class="flex items-center py-2 justify-center">
                  <span class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                      <path fill-rule="evenodd"
                        d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                        clip-rule="evenodd" />
                    </svg>
                  </span>
                  {{ \Carbon\Carbon::create($index)->format('j.m.Y') }} ( {{ count($date['repaired'] ?? []) }} )
                </div>

                <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm">
                  <thead>
                    <tr>
                      <th class="w-8 border border-gray-400 dark:border-gray-700 py-3 text-center">#</td>
                      <th class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">Номер кассеты
                        </td>
                      <th class="w-20 border border-gray-400 dark:border-gray-700 py-3 text-center">Время</td>
                      <th class="w-20 border border-gray-400 dark:border-gray-700 py-3 text-center">Действие</td>
                    </tr>
                  </thead>
                  @foreach ($date['repaired'] ?? [] as $index => $item)
                    <tr class="hover:bg-emerald-800/50 odd:bg-neutral-700/50">
                      <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                        {{ $loop->count - $loop->index }}</td>
                      <td class="border border-gray-400 dark:border-gray-700 px-2 py-1">
                        {{ $item->number }}{{ $item->var1 ? ", повтор от $item->var1" : '' }}</td>
                      <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                        {{ $item->created_at->format('H:i:s') }}
                      </td>
                      <td class="border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                        @if ($item->created_at->format('Y-m-d') === now()->format('Y-m-d'))
                          <form action="{{ route('cassette-delete') }}" method="post">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="submit" value="Удалить">
                          </form>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </table>


                @isset($date['incoming'])
                  <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-5">
                    @foreach ($date['incoming'] ?? [] as $index => $item)
                      <tr>
                        <td class="w-8 border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">*</td>
                        <td class="border border-gray-400 dark:border-gray-700 px-2 py-1">Приход
                          {{ $item->number }}</td>
                        <td class="w-20 border border-gray-400 dark:border-gray-700 px-2 py-1 text-center">
                          @if ($item->created_at->format('Y-m-d') === now()->format('Y-m-d'))
                            <form action="{{ route('cassette-delete') }}" method="post">
                              @method('delete')
                              @csrf
                              <input type="hidden" name="id" value="{{ $item->id }}">
                              <input type="submit" value="Удалить">
                            </form>
                          @else
                            -
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </table>
                @endisset


              </div>
            @endforeach
          @endif

        </div>
      </div>
    </div>
  </div>


  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <script>
    let html5Qrcode = null;
    const scannerId = "scanner-preview";

    function openScanner() {
      // Показываем модалку (удаляем класс hidden)
      document.getElementById('qr-modal').classList.remove('hidden');

      // Инициализируем чистый экземпляр сканера, если еще не создан
      if (!html5Qrcode) {
        html5Qrcode = new Html5Qrcode(scannerId);
      }

      // Запуск камеры (environment означает заднюю камеру смартфона)
      html5Qrcode.start({
          facingMode: "environment"
        }, {
          fps: 25,
          qrbox: function(width, height) {
            // Динамический размер рамки прицела (70% от ширины видео)
            const minEdge = Math.min(width, height);
            const qrboxSize = Math.floor(minEdge * 0.7);
            return {
              width: qrboxSize,
              height: qrboxSize
            };
          }
        },
        (decodedText) => {
          // Успех: записываем в инпут и закрываем
          document.getElementById('qr-result').value = decodedText;
          closeScanner();
        },
        (errorMessage) => {
          // Ошибка поиска QR в кадре (игнорируем)
        }
      ).catch(err => {
        console.error("Ошибка запуска камеры:", err);
        alert("Не удалось получить доступ к камере.");
        closeScanner();
      });
    }

    function closeScanner() {
      // Прячем модалку
      document.getElementById('qr-modal').classList.add('hidden');

      // Обязательно выключаем камеру, чтобы освободить ресурсы устройства
      if (html5Qrcode && html5Qrcode.isScanning) {
        html5Qrcode.stop().catch(err => console.error("Ошибка остановки:", err));
      }
    }
  </script>


</x-app-layout>
