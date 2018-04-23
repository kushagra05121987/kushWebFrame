{{--Enctype from the attribute gets overridden when using files = true--}}
{{ Form::open(array('route' => array('letter.send', 'user', 'id' => 30), 'enctype' => 'text/plain', 'files' => true)) }}
    {{ Form::label('username', "Enter Username: ") }}
    {{ Form::text('name', $oldname ?? 'Something', array('id' => 'username', 'class' => 'form-control', 'placeholder' => 'Please enter username')) }}



    {{ Form::label('password', "Enter Password: ") }}
    {{-- Cannot use value in password--}}
    {{ Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => 'Please enter password', 'value'=> $oldpassword ?? 'something')) }}

    {{ Form::label('file', "Select File: ") }}
{{-- Value is not allowed in file--}}
    {{ Form::file('file', array('id' => 'file', 'class' => 'form-control', 'placeholder' => 'Please select file')) }}

    {{ Form::label('dropdown', "Select One Option: ") }}
    {{ Form::select('dowpdown', array('s' => 'small', 'l' => 'large', 'm' => 'medium'), 'l', array('id' => 'dropdown', 'class' => 'form-control', 'placeholder' => 'Please select Options')) }}

    {{ Form::label('choose', "Choose options: ") }}
    {{ Form::checkbox('choose[]', '1', false, array('id' => 'choose', 'class' => 'form-control', 'placeholder' => 'Please select Options')) }}
    {{ Form::checkbox('choose[]', '2', true, array('id' => 'choose2', 'class' => 'form-control', 'placeholder' => 'Please select Options')) }}

    {{ Form::label('choose_once', "Choose option: ") }}
    {{ Form::radio('radio', '2', true, array('id' => 'choose_option1', 'class' => 'form-control', 'placeholder' => 'Please select Options')) }}
    {{ Form::radio('radio', '3', false, array('id' => 'choose_option2', 'class' => 'form-control', 'placeholder' => 'Please select Options')) }}

    {{ Form::label('textarea', "Please enter your description ") }}
    {{ Form::textarea('textarea', 'Dummy Text', array('id' => 'textarea', 'class' => 'form-control', 'placeholder' => 'Please enter the description')) }}

    {{ Form::hidden('hidden', '200049', array('id' => 'hidden', 'class' => 'form-control', 'placeholder' => 'Please enter the description')) }}

    {{ Form::label('email', "Please enter your email ") }}
    {{ Form::email('email', 'abs@ff.com', array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Please enter the email')) }}

    {{ Form::label('number', "Please enter your number ") }}
    {{ Form::number('number', '20', array('id' => 'number', 'class' => 'form-control', 'placeholder' => 'Please enter the number')) }}

    {{ Form::label('range', "Please choose your range ") }}
    {{ Form::selectRange('range', 10, 100, array('id' => 'range', 'class' => 'form-control', 'placeholder' => 'Please enter the range')) }}


    {{ Form::label('month', "Please choose your day ") }}
    {{ Form::selectMonth('month', array('id' => 'month', 'class' => 'form-control', 'placeholder' => 'Please enter the month')) }}

    {{ Form::select('animal', array(
    'Cats' => array('leopard' => 'Leopard'),
    'Dogs' => array('spaniel' => 'Spaniel'),
    )) }}

    {{ Form::button('Hit this button', array('id' => 'button', 'class' => 'form-control')) }}

    {{ Form::myfield('divine') }}

{{-- Generates hidden csrf token input field. The csrf token generated here will be placed in user's session also and will keep getting updated as new form tokens are genrated.--}}
    {{Form::token()}}

    {{ Form::submit("Submit ", array('name' => 'sbmt')) }}
{{ Form::close() }}




{{--<form method="post" enctype="multipart/form-data" action="<?php echo URL::route('letter.send'); ?> ">--}}
    {{--<input name="name" value="<?php echo $oldname ?? ""; ?>"/>--}}
    {{--<input name="password" value="<?php echo $oldpassword ?? ""; ?>" />--}}
    {{--<input name="file" type="file" />--}}
    {{--<input name="sbmt" type="submit" />--}}
{{--</form>--}}