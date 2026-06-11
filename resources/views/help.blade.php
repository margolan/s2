<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Help</title>
</head>

<body>

  <div class="h-screen dark:text-gray-300 bg-[url(/public/bg_index.jpg)] bg-center bg-cover overflow-scroll">
    <div class="w-6xl px-5 py-10 dark:bg-neutral-900/80 mx-auto">

      <div class="">
        <h1 class="text-3xl font-semibold"><a href="{{ route('help') }}">Help</a></h1>
      </div>

      {{-- Table of Contents --}}

      <div class="p-5">
        <p class="py-3">Содержание</p>
        <ol class="list-decimal list-inside">
          <li><a href="#select">Методы выборки (Получение данных / Поиск)</a></li>
          <ol class="list-[lower-alpha] list-inside ml-5">
            <li><a href="#where">Все варианты фильтрации (WHERE условия)</a></li>
            <li><a href="#sort">Сортировка, Группировка и Лимиты</a></li>
            <li><a href="#count">Агрегатные методы (Запросы, возвращающие числа) </a></li>
            <li><a href="#pagination">Постраничный вывод (Пагинация)</a></li>
            <li><a href="#when">Условные запросы (По ЛП)</a></li>
            <li><a href="#query">Переход от Модели к Конструктору</a></li>
          </ol>
          <li><a href="#create">Методы создания и сохранения (Insert / Update)</a></li>
          <li><a href="#searchAndCreate">Умные методы «Найди или Создай / Обнови»</a></li>
          <li><a href="#delete">Методы удаления (Delete)</a></li>
          <li><a href="#softDelete">Методы работы с Мягким удалением (Soft Deletes)</a></li>
          <li><a href="#property">Проверка состояния модели (Dirty, Clean, Original)</a></li>
          <li><a href="#relations">Методы отношений (Relationships / Загрузка связей)</a></li>
          <li><a href="#serialization">Преобразование данных (Сериализация)</a></li>
          <li><a href="#other">Прочее</a></li>
        </ol>
      </div>

      {{-- Model --}}

      <div>
        <h2 id="select" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">1. Методы выборки
          (Получение данных /
          Поиск)</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">
          Эти методы используются для извлечения записей из базы данных. Почти все они возвращают либо объект модели,
          либо коллекцию (Collection).
        </p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr class="bg-gray-100 dark:bg-gray-800">
            <th class="w-1/3 border border-gray-300 dark:border-gray-600 p-2 text-left">Метод</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 text-left">Описание</th>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">all($columns = ['*'])</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Получает все записи из таблицы. Можно
              передать массив конкретных колонок.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">get($columns = ['*'])</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Выполняет сформированный запрос и
              возвращает коллекцию результатов.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">find($id)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Ищет запись по её первичному ключу (id).
              Если не найдено — вернет null.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">findOrFail($id)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Ищет по id. Если записи нет —
              выбрасывает
              исключение <code class="text-xs">ModelNotFoundException</code> (автоматически отдает ошибку 404 на
              фронтенд).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">first()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает первую запись,
              соответствующую
              условиям запроса.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">firstOrFail()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает первую запись или выбрасывает
              404 ошибку, если ничего не найдено.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">firstWhere($col, $op, $val)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Быстрый хелпер: делает <code
                class="text-indigo-600 dark:text-indigo-400">where()</code> и сразу возвращает <code
                class="text-indigo-600 dark:text-indigo-400">first()</code>.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">value($column)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Получает значение только одной
              конкретной
              колонки из первой найденной записи (минуя создание объекта модели).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">pluck($column, $key)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает коллекцию, состоящую только
              из
              значений указанной колонки. Если передан $key, то коллекция будет ассоциированной (ключ => значение).
            </td>
          </tr>
        </table>

        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-4 mb-1">Подробный поиск</h3>
        <p id="where" class="text-gray-600 dark:text-gray-400 text-sm mb-2">а. Все варианты фильтрации (WHERE
          условия)</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">where($col, $op, $val)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">
              Базовый метод. <br>
              <span class="text-xs text-gray-500"><code
                  class="bg-gray-100 dark:bg-gray-800 px-1 rounded">where('status', 'active')</code>
                (равенство)</span><br>
              <span class="text-xs text-gray-500"><code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">where('votes',
                  '>=', 100)</code> (с оператором)</span>        </td>
            </tr>
            <tr>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code class="text-indigo-600 dark:text-indigo-400">orWhere($col, $op, $val)</code></td>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Добавляет условие OR (ИЛИ).</td>
            </tr>
            <tr>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code class="text-indigo-600 dark:text-indigo-400">whereNot($col, $op, $val)</code></td>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Инвертирует условие (отрицание NOT).</td>
            </tr>
            <tr>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code class="text-indigo-600 dark:text-indigo-400">whereIn() / whereNotIn()</code></td>
                <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Проверяет, входит ли значение в массив: <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">whereIn('id',
                  [1, 2, 3])</code>.
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">whereBetween()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Фильтр диапазона (от и до): <code
                class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">whereBetween('created_at', [$start,
                $end])</code>. Поддерживает <code class="text-indigo-600 dark:text-indigo-400">whereNotBetween()</code>.
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">whereNull() / whereNotNull()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Проверка поля на значение NULL в базе
              данных.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">whereDate / Month / Day / Year / Time</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Умная фильтрация по компонентам даты.
              Например: <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">whereMonth('created_at',
                '05')</code>.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">whereColumn($col1, $col2)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Сравнивает два поля таблицы между собой:
              <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">whereColumn('updated_at', '>',
                'created_at')</code>.
            </td>
          </tr>
        </table>

        <p id="sort" class="text-gray-600 dark:text-gray-400 text-sm mb-2">b. Сортировка, Группировка и Лимиты</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">orderBy($col, $direction)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Сортировка по полю (<code
                class="text-xs">asc</code> — по возрастанию, <code class="text-xs">desc</code> — по убыванию).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">latest($col) / oldest()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Быстрая сортировка по дате (от новых к
              старым или наоборот). По умолчанию поле <code class="text-xs">created_at</code>.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">inRandomOrder()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Сортировка результатов в случайном
              порядке.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">groupBy($columns)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Группировка строк таблицы (часто
              используется совместно с подсчетами).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">having($col, $op, $val)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Фильтрация сгруппированных данных
              (работает строго после метода <code class="text-xs">groupBy</code>).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">take($val) / limit($val)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Ограничивает количество возвращаемых
              строк
              (на уровне SQL конструкции LIMIT).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">skip($val) / offset($val)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Пропускает указанное количество строк
              (необходимо для построения кастомной пагинации).</td>
          </tr>
        </table>

        <p id="count" class="text-gray-600 dark:text-gray-400 text-sm mb-2">c. Агрегатные методы (Запросы,
          возвращающие числа)
        </p>
        <p class="text-xs text-gray-500 mb-2">Эти методы завершают цепочку запроса (как и метод get()), но возвращают
          не коллекции, а число или булево значение.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">count()</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает общее количество строк,
              подходящих под заданные условия.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">max($col) / min($col)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Находит максимальное или минимальное
              значение в указанной колонке (например, максимальный ID).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">avg($column)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Вычисляет среднее значение указанной
              колонки.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">sum($column)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Суммирует все числовые значения в
              указанной колонке.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">exists()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает true, если в базе есть хотя
              бы
              одна строка, удовлетворяющая условиям (работает быстрее, чем проверка count() > 0).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">doesntExist()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Противоположность метода exists()
              (возвращает true, если ни одной записи не найдено).</td>
          </tr>
        </table>

        <p id="pagination" class="text-gray-600 dark:text-gray-400 text-sm mb-2">d. Постраничный вывод (Пагинация)</p>
        <p class="text-xs text-gray-500 mb-2">Используются вместо метода get() в самом конце цепочки условий.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">paginate($perPage = 15)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Разбивает результат на страницы.
              Автоматически считывает GET-параметр ?page=. Возвращает объект пагинатора, ссылки которого в Blade
              выводятся как: <code class="text-xs font-mono">{ { $visitors->links() } }</code>.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">simplePaginate($perPage)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Упрощенная пагинация (в шаблоне
              выводятся
              только кнопки «Назад» и «Вперед», без номеров страниц). Работает значительно быстрее на огромных объемах
              данных.</td>
          </tr>
        </table>

        <p id="when" class="text-gray-600 dark:text-gray-400 text-sm mb-2">e. Условные запросы (По ЛП)</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-4 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">when($value, Closure)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Мега-полезный метод. Выполняет кусок
              SQL-запроса внутри замыкания только в том случае, если первый параметр ($value) эквивалентен true
              (например, если пользователь применил фильтр поиска).</td>
          </tr>
        </table>

        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg shadow-inner font-mono text-xs mb-6 overflow-x-auto">
          <p class="text-gray-500 mb-1">// Пример использования метода when()</p>
          <span class="text-purple-400">$search</span> = <span class="text-purple-400">$request</span>-&gt;input(<span
            class="text-green-400">'search'</span>);<br><br>
          <span class="text-purple-400">$visitors</span> = Visitor::query()<br>
          &nbsp;&nbsp;&nbsp;&nbsp;-&gt;when(<span class="text-purple-400">$search</span>, <span
            class="text-blue-400">function</span> (<span class="text-purple-400">$query</span>, <span
            class="text-purple-400">$search</span>) {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-blue-400">return</span> <span
            class="text-purple-400">$query</span>-&gt;where(<span class="text-green-400">'url'</span>, <span
            class="text-green-400">'like'</span>, <span class="text-green-400">"%{<span
              class="text-purple-400">$search</span>}%"</span>);<br>
          &nbsp;&nbsp;&nbsp;&nbsp;})<br>
          &nbsp;&nbsp;&nbsp;&nbsp;-&gt;get();
        </div>

        <p id="query" class="text-gray-600 dark:text-gray-400 text-sm mb-2">f. Переход от Модели к Конструктору
        </p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">query()</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Хорошая практика начинать сложные
              цепочки
              запросов с этого метода: <code class="text-xs">Visitor::query()->where(...)->get();</code>. Помогает
              IDE
              лучше понимать контекст и автодополнение методов Eloquent.</td>
          </tr>
        </table>


        <h2 id="create" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">2. Методы создания и
          сохранения
          (Insert / Update)</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Методы для добавления новых данных в таблицы или обновления
          уже существующих записей.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">save(array $options)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Универсальный метод объекта. Если
              модель
              новая — выполняет INSERT. Если объект был ранее подгружен из базы — выполняет UPDATE измененных полей.
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">create(array $attr)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Создает новую запись в базе и сразу
              возвращает объект этой модели. <span class="text-red-500 font-semibold">Важно:</span> требует
              обязательной настройки свойств <code class="text-xs">$fillable</code> или <code
                class="text-xs">$guarded</code> в классе модели (защита от массового заполнения).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">forceCreate(array $attr)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Создает запись в базе данных напрямую,
              полностью игнорируя любые ограничения массового заполнения <code class="text-xs">$fillable /
                $guarded</code>.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">update(array $attr)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Массово обновляет указанные поля у
              текущей подгруженной модели либо у целой цепочки сформированного запроса.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">push()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Сохраняет изменения не только самой
              текущей модели, но и автоматически сохраняет данные во всех её загруженных связях (отношениях).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">touch()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Принудительно обновляет только
              временную
              метку (таймстэмп) <code class="text-xs">updated_at</code> текущей записи в базе.</td>
          </tr>
        </table>


        <h2 id="searchAndCreate" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">3. Умные методы
          «Найди или Создай /
          Обнови»</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Помогают избавиться от написания лишних конструкций условий
          с
          ветвлением if/else.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">firstOrCreate(array $attr, array $values)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Ищет запись по критериям из массива
              $attributes. Если находит — возвращает её объект. Если нет — создает и сохраняет новую запись, объединяя
              массивы параметров.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">firstOrNew(array $attr, array $values)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">То же самое, что и метод <code
                class="text-xs">firstOrCreate</code>, но в случае отсутствия записи в базе, он лишь возвращает новый
              объект в памяти, не сохраняя его автоматически (требуется вызвать <code class="text-xs">->save()</code>
              вручную).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">updateOrCreate(array $attr, array $values)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Ищет строку по $attributes. Если
              находит
              — обновляет её поля данными из массива $values. Если не находит — создает новую запись.</td>
          </tr>
        </table>


        <h2 id="delete" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">4. Методы удаления
          (Delete)</h2>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">delete()</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Удаляет текущую выбранную запись из
              базы
              данных (вызывается строго на объекте модели).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">destroy($ids)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Статический метод. Быстро удаляет
              записи
              по их ID без предварительной загрузки моделей в память. Принимает один ID, массив идентификаторов <code
                class="text-xs">destroy([1, 2, 3])</code> или коллекцию.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">forceDelete()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Принудительно и безвозвратно удаляет
              запись из таблицы физически, если в текущей модели активирован функционал мягкого удаления
              (SoftDeletes).
            </td>
          </tr>
        </table>


        <h2 id="softDelete" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">5. Методы работы с
          Мягким удалением
          (Soft Deletes)</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Данные методы доступны только при условии
          подключения
          в классе модели трейта: <code class="text-xs font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">use
            Illuminate\Database\Eloquent\SoftDeletes;</code>.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">withTrashed()</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Включает в итоговую выборку запроса как
              активные, так и ранее «мягко удаленные» записи (у которых заполнено поле <code
                class="text-xs">deleted_at</code>).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">onlyTrashed()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Формирует запрос, выбирающий из таблицы
              <span class="font-semibold text-amber-600">исключительно</span> те записи, которые ранее были мягко
              удалены.
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">restore()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Восстанавливает мягко удаленную запись
              на
              уровне БД (полностью очищает значение поля <code class="text-xs">deleted_at</code>).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">trashed()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Проверяет состояние объекта модели.
              Возвращает булево значение <code class="text-xs">true/false</code> в зависимости от того, удалена ли
              модель мягко.</td>
          </tr>
        </table>


        <h2 id="property" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">6. Проверка состояния
          модели (Dirty,
          Clean, Original)</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Используются в логике, когда необходимо отследить
          изменения полей модели до момента фиксации данных в БД.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">isDirty($attributes)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает true, если какие-либо
              свойства
              модели (или конкретное поле) были изменены в коде, но изменения еще не сохранены в базу данных.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">isClean($attributes)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Противоположность метода <code
                class="text-xs">isDirty</code>. Возвращает true, если переданные поля модели остались абсолютно
              нетронутыми.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">wasChanged($attributes)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Возвращает true, если указанные поля
              были
              изменены во время выполнения последнего сохранения (<code class="text-xs">save()</code> или <code
                class="text-xs">update()</code>) в текущем цикле выполнения скрипта.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">getOriginal($attribute)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Позволяет извлечь первоначальные чистые
              значения полей модели, какими они были на момент загрузки из базы данных, даже если ты уже переопределил
              их значения в коде.</td>
          </tr>
        </table>


        <h2 id="relations" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">7. Методы отношений
          (Relationships /
          Загрузка связей)</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Применяются для оптимизации структуры запросов к
          связанным таблицам БД.</p>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-8 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">with($relations)</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">
              <span class="font-semibold">Жадная загрузка (Eager Loading)</span>. Подгружает связи одновременно с
              основной моделью за минимальное количество SQL запросов, превентивно решая проблему производительности
              N+1.<br>
              <span class="text-xs text-gray-500">Пример: <code
                  class="bg-gray-100 dark:bg-gray-800 px-1 rounded">User::with('posts')->get();</code></span>
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">load($relations)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">
              <span class="font-semibold">Ленивая жадная загрузка (Lazy Eager Loading)</span>. Подгружает необходимые
              связи для объекта модели, которая уже была ранее выбрана из базы данных.<br>
              <span class="text-xs text-gray-500">Пример: <code
                  class="bg-gray-100 dark:bg-gray-800 px-1 rounded">$user->load('posts');</code></span>
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">loadMissing($relations)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Дополнительно подгружает указанную
              связь
              для модели только в том случае, если она не была загружена у этого объекта ранее.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">withCount($relations)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">
              Подсчитывает общее количество связанных строк без прямой загрузки самих записей в память (добавляет к
              результату поле динамического атрибута <code class="text-xs">{relation}_count</code>).<br>
              <span class="text-xs text-gray-500">Пример: <code
                  class="bg-gray-100 dark:bg-gray-800 px-1 rounded">User::withCount('posts')->get();</code></span>
            </td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">has($relation)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Фильтрует родительские модели строго на
              основе факта наличия связи. (Например: выбрать только тех пользователей, у которых есть хотя бы один
              опубликованный пост).</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">whereHas($rel, Closure)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Более мощная вариация метода <code
                class="text-xs">has</code>. Позволяет наложить специфические условия фильтрации на связанную таблицу
              внутри замыкания (Например: выбрать пользователей, имеющих посты, созданные строго в текущем месяце).
            </td>
          </tr>
        </table>


        <h2 id="serialization" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">8. Преобразование
          данных
          (Сериализация)</h2>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/3 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <code class="text-indigo-600 dark:text-indigo-400">toArray()</code>
            </td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Превращает объект модели (включая все
              её
              предварительно загруженные связи) в стандартный ассоциативный массив PHP.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">toJson($options)</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Преобразует текущие данные модели в
              валидную строку формата JSON.</td>
          </tr>
          <tr>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50"><code
                class="text-indigo-600 dark:text-indigo-400">replicate()</code></td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">Клонирует текущую модель. Создает
              точную
              копию существующего объекта в оперативной памяти, очищая поля первичного ключа (<code
                class="text-xs">id</code>) и временных меток, полностью подготавливая объект к сохранению в качестве
              новой независимой записи.</td>
          </tr>
        </table>


        <h2 id="other" class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-6 mb-2">Прочее</h2>
        <table
          class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm mb-6 text-gray-800 dark:text-gray-200">
          <tr>
            <td class="w-1/8 border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              Telegram</td>
            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 bg-gray-50 dark:bg-gray-900/50">
              <p>Register - https://api.telegram.org/bot{API-key}/setWebhook?url=https://{your-web-site.com}/api/tg</p>
              <p>Check - https://api.telegram.org/bot{API-key}/getWebhookInfo</p>

              <hr class="my-3">

              <h3>1. Базовые данные обычного сообщения (message)</h3>
              <p>Данные отправителя:</p>
              <ul class="list-disc pl-5 pb-5">
                <li> $request->input('message.from.id') — уникальный ID самого человека (не чата, а именно
                  пользователя).
                </li>
                <li>
                  $request->input('message.from.first_name') — имя (например, Margulan).
                </li>
                <li>
                  $request->input('message.from.username') — никнейм без собачки (например, margulan0x0). Если у юзера
                  нет юзернейма, вернет null.
                </li>
                <li>
                  $request->input('message.from.language_code') — язык интерфейса (например, ru или en).
                </li>
              </ul>

              <p>Данные чата:</p>
              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('message.chat.type') — тип чата. Может быть private (личка с ботом), group или
                  supergroup(групповые чаты), channel (канал).
                </li>
                <li>
                  По ЛП: Если бот работает и в личке, и в группах, проверка типа чата помогает понять, нужно ли отвечать
                  конкретному человеку или флудить в общую группу.
                </li>
              </ul>

              <h3>2. Различные типы контента (Медиа и файлы)</h3>

              <p>Фотографии (photo):</p>
              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('message.photo') — возвращает массив картинок в разных разрешениях (от превью до
                  оригинала).
                </li>
                <li>
                  Чтобы взять самую четкую (последнюю в массиве) и узнать её ID: $request->input('message.photo.' .
                  (count($request->input('message.photo', [])) - 1) . '.file_id').
                </li>
              </ul>

              <p>Документы и файлы (document):</p>
              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('message.document.file_id') — ID файла для скачивания.
                </li>
                <li>
                  $request->input('message.document.file_name') — реальное имя файла (например, report.pdf).
                </li>
                <li>
                  $request->input('message.document.mime_type') — тип файла (application/pdf, image/png).
                </li>
              </ul>

              <p>Голосовые сообщения (voice) и Аудио (audio):</p>
              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('message.voice.file_id') — ID голосовухи.
                </li>
                <li>
                  $request->input('message.voice.duration') — длительность в секундах.
                </li>
              </ul>

              <h3>3. Служебные триггеры (Когда в чате что-то происходит)</h3>

              <p>Новый участник в группе (например, бота добавили в чат к геймерам):</p>
              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('message.new_chat_members') — массив с данными пользователей, которые вошли в чат.
                  Если
                  там есть is_bot: true и это твой бот, можно отправить в чат приветствие: "Всем привет, я ваш новый
                  бот!".
                </li>
                <li>
                  Кто-то вышел или кикнули:
                  $request->input('message.left_chat_member') — данные ушедшего юзера.
                </li>
              </ul>

              <h3>4. Нажатия на инлайн-кнопки (callback_query)</h3>

              <ul class="list-disc pl-5 pb-5">
                <li>
                  $request->input('callback_query.id') — ID самого клика (нужен, чтобы подтвердить Telegram, что кнопка
                  нажата).
                </li>
                <li>
                  $request->input('callback_query.from.id') — кто нажал на кнопку.
                </li>
                <li>
                  $request->input('callback_query.data') — самое главное поле. Это секретная строка-команда, которую ты
                  сам зашил в кнопку при её создании (например, delete_record_5 или accept_pincode).
                </li>
                <li>
                  $request->input('callback_query.message.message_id') — ID сообщения, под которым находилась кнопка
                  (чтобы твой бот мог, например, отредактировать или удалить это сообщение после нажатия).
                </li>
              </ul>
            </td>
          </tr>
        </table>


      </div>
    </div>
  </div>

</body>

</html>
