{{-- localized date using jenssegers/date --}}
@php
    $value = data_get($entry, $column['name']);
@endphp

<span data-order="{{ $value }}">
    @if (!empty($value))
	{{ Date::parse($value)->format(($column['format'] ?? config('backpack.base.default_date_format'))) }}
    @endif
</span>