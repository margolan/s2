<div class="WRAP SCHEDULE max-w-max text-sm flex text-gray-300 p-3 bg-zinc-800 rounded-lg" x-data="{ hoverIndex: null }">
  <div class="NAMES w-max flex flex-col">
    <div class="px-3 h-14 flex items-center bg-zinc-800">Имя</div>
    @foreach ($actualSchedule as $item)
      <div class="px-3 py-1 text-gray-300 odd:bg-zinc-800 even:bg-zinc-700 ">
        {{ explode(' ', $item['worker_name'])[1] }}
      </div>
    @endforeach
  </div>
  <div class="DATA flex flex-col overflow-x-auto">
    <div class="h-14 bg-zinc-800">
      <div class="ROW ROW_DATE w-max flex">
        @foreach ($calendar as $index => $item)
          <div
            class="CELL w-7 py-1 text-gray-300 font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
            @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
            :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
            {{ $item['date'] }}</div>
        @endforeach
      </div>
      <div class="ROW ROW_DOW w-max flex">
        @foreach ($calendar as $index => $item)
          <div
            class="CELL w-7 py-1 text-gray-300 uppercase font-mono flex justify-center {{ $item['is_weekend'] ? 'text-red-600 bg-red-500/10' : '' }}"
            @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
            :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
            {{ $item['dow'] }}</div>
        @endforeach
      </div>
    </div>
    @foreach ($actualSchedule as $item)
      <div class="ROW ROW_DATA w-max flex odd:bg-zinc-800 even:bg-zinc-700">
        @foreach ($item['schedule_data'] as $index => $day)
          <div
            class="CELL w-7 py-1 flex justify-center 
                        {{ $day === 'O' ? 'text-gray-400' : '' }}
                        {{ $day === '?' ? 'text-gray-400' : '' }}
                        {{ $day === '+' ? 'text-emerald-400' : '' }}
                        {{ $day === 'D' ? 'bg-orange-400/10 text-orange-400 rounded-lg' : '' }}
                        {{ $calendar[$index]['is_weekend'] ? 'bg-red-500/10' : '' }}"
            @mouseenter="hoverIndex={{ $index }}" @mouseleave="hoverIndex = null"
            :class="{ 'bg-zinc-700/50': hoverIndex === {{ $index }} }">
            {{ $day }}</div>
        @endforeach
      </div>
    @endforeach
  </div>
</div>
