<x-guest-layout>

  {{-- ======================================= [ NOTIFICATION ] ======================================= --}}

  @if ($errors->any())
    <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition x-init="setTimeout(() => show = false, 6000)">
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
    <div class="w-full absolute py-2 top-0 left-0 flex items-center justify-center" x-data="{ show: true }" x-show="show"
      x-transition x-init="setTimeout(() => show = false, 6000)">
      <div class="min-w-32 bg-amber-500 text-sm px-5 py-2 flex items-center text-black rounded-lg mr-3">
        <p>{{ session('status') }}</p>
      </div>
      <div class="w-5 h-5 flex items-center justify-center bg-amber-500 cursor-pointer rounded-full"
        @click="show = false">&#215;</div>
    </div>
  @endif

  {{-- ======================================= [ REQUESTED SCHEDULE ] ======================================= --}}

  @dump($routes)

  <div x-data="{
      pin: [],
      async addDigit(digit) {
          if (this.pin.length < 4) {
              this.pin.push(digit);
              if (this.pin.length === 4) {
                  // Даем крошечную задержку, чтобы юзер увидел последнюю звездочку
                  await new Promise(resolve => setTimeout(resolve, 100));
                  this.$refs.pinForm.submit();
              }
          }
      }
  }" class="flex items-center justify-center text-gray-100 py-5">

    <div class="px-6 py-8 rounded-lg flex flex-col justify-center border border-gray-500">

      <div class="display w-full flex items-center justify-center gap-3 p-3 mb-5 border border-gray-500">
        <template x-for="i in [0,1,2,3]">
          <div class="w-10 h-10 border-b-2 flex items-center justify-center text-2xl"
            :class="pin[i] ? 'border-emerald-500 text-emerald-500' : 'border-gray-500 text-gray-600'">
            <span x-text="pin[i] ? '*' : ''"></span>
          </div>
        </template>
      </div>

      <form x-ref="pinForm" action="{{ route('key-pincode') }}" method="post" class="flex flex-col gap-3">
        @csrf
        <input type="hidden" name="pincode" :value="pin.join('')">

        <div class="flex justify-between">
          <template x-for="n in [1,2,3]">
            <div @click="addDigit(n)"
              class="w-16 h-16 flex items-center justify-center border border-gray-500 cursor-pointer hover:bg-gray-700 active:bg-emerald-600 transition-colors"
              x-text="n">
            </div>
          </template>
        </div>
        <div class="flex justify-between">
          <template x-for="n in [4,5,6]">
            <div @click="addDigit(n)"
              class="w-16 h-16 flex items-center justify-center border border-gray-500 cursor-pointer hover:bg-gray-700 active:bg-emerald-600 transition-colors"
              x-text="n">
            </div>
          </template>
        </div>
        <div class="flex justify-between">
          <template x-for="n in [7,8,9]">
            <div @click="addDigit(n)"
              class="w-16 h-16 flex items-center justify-center border border-gray-500 cursor-pointer hover:bg-gray-700 active:bg-emerald-600 transition-colors"
              x-text="n">
            </div>
          </template>
        </div>

        <div class="flex justify-between">
          <div @click="pin = []"
            class="w-16 h-16 flex items-center justify-center border border-gray-500 cursor-pointer hover:bg-red-900 text-xs">
            C</div>

          <div @click="addDigit('0')"
            class="w-16 h-16 flex items-center justify-center border border-gray-500 cursor-pointer hover:bg-gray-700">
            0
          </div>

          <div class="w-16 h-16"></div>
        </div>
      </form>
    </div>
  </div>

</x-guest-layout>
