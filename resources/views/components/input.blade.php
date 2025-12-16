@props(['label'])

<div class="mb-4">
    <label class="block text-sm font-medium text-slate-600 mb-1">
        {{ $label }}
    </label>
    <input {{ $attributes->merge([
        'class' => 'w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200'
    ]) }}>
</div>
