<html>
    <head>
        <title> Default Template </title>
    </head>
    <body>
        @include('blade.header', array('message' => 'This is a Header'))
        @yield('content')
        @include('blade.footer', array('message' => 'This is a Footer'))
    </body>
</html>