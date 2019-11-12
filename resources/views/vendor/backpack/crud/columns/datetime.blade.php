{{-- localized datetime using jenssegers/date --}}
@php
    $value = data_get($entry, $column['name']);
@endphp

<span data-order="{{ $value }}">
    @if (!empty($value))
	{{ Date::parse($value)->format(($column['format'] ?? config('backpack.base.default_datetime_format'))) }}
    @endif
</span>