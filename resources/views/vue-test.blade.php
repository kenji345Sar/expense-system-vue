{{-- resources/views/vue-test.blade.php --}}
@extends('layouts.app')

@section('content')
  <div id="app">
    <example-component></example-component>
  </div>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
