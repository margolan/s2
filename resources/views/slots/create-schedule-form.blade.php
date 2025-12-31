<div class="py-5">
  <form action="" class="flex flex-col gap-5">
    <div class="flex gap-5">
      <select name="month">
        @foreach ($yearAndMonth['month'] as $index => $month)
          <option value="{{ $index }}" @if ($yearAndMonth['current'][0] == $index) selected @endif>
            {{ $month }} </option>
        @endforeach
      </select>
      <select name="year">
        @foreach ($yearAndMonth['year'] as $year)
          <option value="{{ $year }}" @if ($yearAndMonth['current'][1] == $year) selected @endif>{{ $year }}</option>
        @endforeach
      </select>
    </div>
    <input type="file" class="custom-file-input" name="file">
  </form>
</div>
<hr class="border border-red-500">
<?php

echo '<pre>';
print_r($yearAndMonth);
echo '</pre>';

?>
