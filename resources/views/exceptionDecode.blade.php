@include('extended-exception::header')

{{ Aire::open()
  ->route('debug.extendedException')->post() }}

{{ Aire::input('extendedException', 'Extended Exception')->value($extendedException) }}

{{ Aire::textArea('$extendedExceptionJsonPrettyPrint', '$extendedExceptionJsonPrettyPrint')->value($extendedExceptionJsonPrettyPrint)->style('height: 25em;')->readOnly()->disabled() }}

{{ Aire::submit('View') }}

{{ Aire::close() }}

@include('extended-exception::footer')
