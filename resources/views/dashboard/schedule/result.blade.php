@extends('dashboard')
@section('dashboard-content')
  <h1>Result</h1>
  <hr class="border-red-500 my-3">

  @isset($data)
    <pre>
      {{print_r($data, true)}}
    </pre>
  @endisset
@endsection
