@props([
'name',
'label',
'type' => 'text',
'value' => ''
])

<div>
    <label class="block mb-2 font-medium">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name,$value) }}"
        {{ $attributes }}
        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rentalin-primary focus:ring-rentalin-primary">

    @error($name)
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>