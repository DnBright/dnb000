@props(['label' => '', 'name' => '', 'rows' => 3])

<div class="flex flex-col gap-1">
    <label class="text-gray-700 font-medium">{{ $label }}</label>

    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="w-full px-4 py-3 border rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
    ></textarea>
</div>
