@props(['name'])

<input type="text" name="{{ $name }}" value="{{ old($name) }}" class="border p-2" />