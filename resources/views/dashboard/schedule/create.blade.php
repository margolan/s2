<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      График работ
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="py-5">
            <form action="{{ route('schedule-store') }}" enctype="multipart/form-data" method="POST"
              class="max-w-[327px] flex flex-col gap-5 dark:text-gray-800">
              @csrf
              <div class="flex gap-5 ">
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

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
