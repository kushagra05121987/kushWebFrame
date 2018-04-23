<html>
<head>
    <title> Default Template </title>
</head>
<body>
@include('blade.header', array('message' => 'This is a Header'))

@section('trial_section')
    This is parent trial
@stop

@yield('sidebar_left')
@yield('trial_section')
@yield('sidebar_right')
@include('blade.footer', array('message' => 'This is a Footer'))
</body>
</html>