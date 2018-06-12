@component('mail::message')

- User: {{ $user->name }} ({{ $user->email }})
- Time: {{ $timeOfException }}
- Error message: {{ $exception->getMessage() }}
- File: {{ $exception->getFile() }}
- Line: {{ $exception->getLine() }}

@component('mail::panel')

{{ $exception->getTraceAsString() }}

@endcomponent

@endcomponent
