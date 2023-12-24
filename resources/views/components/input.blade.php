@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
]) !!}>
