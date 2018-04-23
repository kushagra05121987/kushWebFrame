@foreach($errors->all('<b>:message<b>') as $error)
    {{ $error }}
@endforeach

{{ $errors -> first('email') }}