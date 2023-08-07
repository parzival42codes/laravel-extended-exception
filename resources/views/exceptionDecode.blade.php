@include('extended-exception::header')

{{ Aire::open()
  ->route('extended-exception.dashboard.work')->post() }}

{{ Aire::input('extendedException', 'Extended Exception')->value($extendedException) }}

{{ Aire::textArea('$extendedExceptionJsonPrettyPrint', 'JSON Pretty Print')->value($extendedExceptionJsonPrettyPrint)->style('height: 25em;')->readOnly()->disabled() }}

{{ Aire::submit('View') }}

{{ Aire::close() }}

@include('extended-exception::footer')
