{{-- image column type --}}
@php
  $value = data_get($entry, $column['name']);

  if (is_array($value)) {
    $value = json_encode($value);
  }
@endphp

<span>
  @if( empty($value) )
    -
  @else
    <a
      href="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
      target="_blank"
    >
      <img
        src="{{ asset( (isset($column['prefix']) ? $column['prefix'] : '') . $value) }}"
        style="
          max-height: {{ isset($column['height']) ? $column['height'] : "25px" }};
          width: {{ isset($column['width']) ? $column['width'] : "auto" }};
          border-radius: 3px;"
      />
    </a>
  @endif
</span>
