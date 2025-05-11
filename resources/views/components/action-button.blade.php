@props(['type' => 'link', 'color' => 'blue', 'href' => '#', 'method' => 'GET'])

@php
$bg = "bg-{$color}-500";
$hover = "hover:bg-{$color}-600";
$text = "text-{$color}-500";
@endphp

@if ($type === 'form')
<form action="{{ $href }}" method="{{ strtolower($method) }}"
  class="block w-fit {{ $attributes->get('formMargin') }}">
  @csrf
  @if (strtoupper($method) !== 'GET')
  @method($method)
  @endif
  <button {{ $attributes->class([
            $bg,
            'text-white',
            'px-3',
            'py-1',
            'rounded',
            'text-sm',
            $hover,
            'block',
        ]) }}>
    {{ $slot }}
  </button>
</form>
@else
<a href="{{ $href }}"
  {{ $attributes->class([
           'px-3',
           'py-1',
           'hover:underline',
           $hover,
       ]) }}>
  {{ $slot }}
</a>
@endif