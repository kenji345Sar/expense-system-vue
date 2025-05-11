@props(['name', 'label', 'type' => 'text', 'value' => null])

@php
$fieldName = is_string($name) ? $name : ''; // 配列になっていないか安全確認
$fieldValue = old($fieldName, $value);
@endphp

<div class="mb-4">
    <label for="{{ $fieldName }}" class="block font-bold mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $fieldName }}"
        id="{{ $fieldName }}"
        value="{{ $fieldValue }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300']) }}>
    @error($fieldName)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>