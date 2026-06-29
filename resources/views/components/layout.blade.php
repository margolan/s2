<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>{{ $title ?? '0x0' }}</title>
</head>

<body class="font-sans antialiased dark:bg-neutral-800 dark:text-neutral-200">
  {{ $slot }}
</body>

</html>
