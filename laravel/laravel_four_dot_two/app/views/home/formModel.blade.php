{{-- If there are other variables with same name as model fields then there will be a preceedence check
Session Flash Data (Old Input)
Explicitly Passed Value
Model Attribute Data
--}}
{{ Form::model($user, array('route' => array('letter.send', 'user', 'id' => 30), 'enctype' => 'text/plain')) }}
{{ Form::text('id') }}
{{ Form::text('email') }}
{{ Form::text('phone') }}
{{ Form::text('password') }}
{{ Form::close() }}