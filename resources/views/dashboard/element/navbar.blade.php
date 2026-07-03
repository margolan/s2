<h1
  class="font-semibold text-gray-800 dark:text-gray-200 px-1 {{ request()->routeIs('schedule.dashboard') ? 'underline underline-offset-3' : '' }}">
  <a href="{{ route('schedule.dashboard') }}">График работ</a>
</h1>
@if (Auth::user()->depart == 'ter')
  <h1
    class="font-semibold text-gray-800 dark:text-gray-200 px-1 {{ request()->routeIs('key.dashboard') ? 'underline underline-offset-3' : '' }}">
    <a href="{{ route('key.dashboard') }}">Ключи</a>
  </h1>
@endif
