@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-xl bg-indigo-50 px-3.5 py-2 text-sm font-semibold text-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-xl px-3.5 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
