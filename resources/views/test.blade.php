<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

  <div class="CONTENT min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 dark:text-gray-100">


    <table class="w-full border-collapse border border-gray-400 dark:border-gray-700 text-sm">
      @foreach ($data as $index => $district)
        @foreach ($district as $item)
          <tr>
            <td class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">{{ $item->reg_number }}</td>
            <td class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">{{ $item->device_address }}</td>
            <td class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">{{ $item->color }}</td>
            <td class="border border-gray-400 dark:border-gray-700 px-2 py-3 text-center">{{ $index }}</td>
          </tr>
        @endforeach
      @endforeach
    </table>


  </div>

</body>

</html>
