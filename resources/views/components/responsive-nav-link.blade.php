@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl bg-indigo-50 px-4 py-3 text-start text-sm font-semibold text-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition duration-150 ease-in-out'
            : 'block w-full rounded-xl px-4 py-3 text-start text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
