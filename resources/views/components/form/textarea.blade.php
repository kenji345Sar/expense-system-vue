@props([
  'name',
  'label',
  'value' => null,
])

@php
$fieldName = is_string($name) ? $name : '';
$fieldValue = old($fieldName, $value);
@endphp

<div class="mb-4">
  <label for="{{ $fieldName }}" class="block font-medium">
    {{ $label }}
  </label>

  <textarea
    name="{{ $fieldName }}"
    id="{{ $fieldName }}"
    rows="3"
    {{ $attributes->merge(['class' => 'w-full border rounded px-3 py-2']) }}
  >{{ $fieldValue }}</textarea>

  @error($fieldName)
  <x-input-error :messages="$errors->get($fieldName)" />
  @enderror
</div>
