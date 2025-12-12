@props(['label' => '', 'name' => '', 'type' => 'text', 'required' => false])

<div class="flex flex-col gap-1">
    <label class="text-gray-700 font-medium">{{ $label }}</label>

    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
    >
</div>
