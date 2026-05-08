<x-app-layout>
  <x-slot name="header">
    <div class="flex">
      @include('dashboard.element.navbar')
    </div>
  </x-slot>


  {{-- @dd($data) --}}

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg ">
        <div class="py-6 sm:px-6 px-3 text-gray-900 dark:text-gray-100">

          {{-- ======================================= [ NOTIFICATION ] ======================================= --}}

          @if ($errors->any())
            <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
                @click="show = false">&#215;</div>
            </div>
          @endif

          @if (session('status'))
            <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }"
              x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)">
              <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
                <p>{{ session('status') }}</p>
              </div>
              <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
                @click="show = false">&#215;</div>
            </div>
          @endif

          {{-- ======================================= [ REQUESTED SCHEDULE ] ======================================= --}}

          
          



        </div>
      </div>
    </div>
  </div>
</x-app-layout>
