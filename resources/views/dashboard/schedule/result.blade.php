@extends('dashboard')
@section('dashboard-content')
  <hr class="border-red-500 my-3">
  <h1>Result</h1>

  @isset($data)
    {{-- {{ $data }} --}}
    <hr>

    @dump($data)
  @endisset

  @if (session('status'))
    <p>{{ session('status') }}</p>
  @endif

  @dump(session('data'))
@endsection
