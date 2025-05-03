@props(['messages'])

@if ($messages)
<ul class="text-red-600 text-sm mt-1">
    @foreach ((array) $messages as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
@endif