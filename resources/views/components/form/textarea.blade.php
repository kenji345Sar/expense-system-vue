@props([
'name',
'label',
'value' => old($name),
])

<div class="mb-4">
    <label for="{{ $name }}" class="block font-medium">
        {{ $label }}
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="3"
        {{ $attributes->merge(['class' => 'w-full border rounded px-3 py-2']) }}>{{ $value }}</textarea>
    <x-input-error :messages="$errors->get($name)" />
</div>