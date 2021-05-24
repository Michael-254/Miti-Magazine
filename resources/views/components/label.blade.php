@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-md text-green-500']) }}>
    {{ $value ?? $slot }}
</label>
