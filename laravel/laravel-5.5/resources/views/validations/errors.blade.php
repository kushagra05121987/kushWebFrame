@foreach($errors -> all('<b>:message</b>') as $error)
    {{ $error }}
@endforeach