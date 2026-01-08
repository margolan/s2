<div class="py-5">
  <form action="{{ route('dashboard') }}" method="POST" class="flex flex-col gap-5">
    @csrf
    <div class="flex gap-5">
      <select name="month">
        @foreach ($date['month'] as $index => $month)
          <option value="{{ $index }}" @if ($date['current'][0] == $index) selected @endif>
            {{ $month }} </option>
        @endforeach
      </select>
      <select name="year">
        @foreach ($date['year'] as $year)
          <option value="{{ $year }}" @if ($date['current'][1] == $year) selected @endif>{{ $year }}
          </option>
        @endforeach
      </select>
    </div>
    <input type="file" class="custom-file-input" name="file">
    <input type="submit" value="Отправить"
      class="w-max bg-white px-3 h-[42px] cursor-pointer border border-gray-800 mr-5">
  </form>
</div>

<hr class="border border-red-500">




<?php

echo '<pre>';
print_r($date);
isset($data) ?? print_r($data);
echo '</pre>';

?>
