@extends('dashboard')

@section('dashboard-content')
  @session('status')
    <div class="fixed top-0 right-0 rounded-bl-lg bg-gray-100 text-gray-900 px-4 py-1">
      {{ session('status') }}
    </div>
  @endsession

  <div class="py-5">

    <form action="{{ route('schedule-store') }}" enctype="multipart/form-data" method="POST"
      class="max-w-[327px] flex flex-col gap-5">
      @csrf
      <div class="flex gap-5">
        <select name="month">
          @foreach ($months as $value => $name)
            <option value="{{ $value }}" @selected($currentMonth == $value)>
              {{ $name }}
            </option>
          @endforeach
        </select>

        <select name="year">
          @foreach ($years as $year)
            <option value="{{ $year }}" @selected($currentYear == $year)>
              {{ $year }}
            </option>
          @endforeach
        </select>
      </div>
      <input type="file" class="custom-file-input w-max text-gray-200" name="file">
      <input type="submit" value="Отправить"
        class="w-max bg-white px-3 h-[42px] cursor-pointer border border-gray-800 mr-5">
    </form>

  </div>

  {{-- @dump($currentMonth); --}}

@endsection
