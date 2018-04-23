@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @component('components.alerts', array('name' => "<script></script>"))
                            @slot('title')
                                Home Page Alert
                            @endslot
                            You are not allowed to access this resource!
                        @endcomponent
                        {{--@alert(array('name' => "Dummy", "title" => "Home Page Alert"))--}}
                        {{--You are not allowed to access this resource!--}}
                        {{--@endalert;--}}
                        @section('navigation')
                            This is a navigation section
                        @endsection
                        Hello, @{{ name }}.
                        @verbatim
                            <div class="container">
                                Hello, {{ name }}.
                            </div>
                        @endverbatim

                        @auth
                            User is authenticated
                        @endauth

                        @guest
                            The user is not authenticated...
                        @endguest

                        @hasSection('navigation')
                            <div class="pull-right">
                                @yield('navigation')
                            </div>

                            <div class="clearfix"></div>
                        @endif
                        @php
                            $time = new \DateTime('2018/02/05');
                        @endphp
                        @datetime($time)

                        @envIf('local')
                        This is a local Environment
                        @elseenvIf('development')
                        This is a development Environment
                        @elseenvIf('production')
                        This is a production Environment
                        @else
                            No Environment Detected
                            @endenvIf

                            @inject('apputils', "appUtility")
                            @php
                                $apputils -> runSerivces();
                            @endphp
                            @php
                                App::setLocale('es');
                            @endphp
                            @lang('I Love Programming')
                            {{ App::getLocale() }}
                            {{ App::isLocale('es') }}
                            {{ __('auth.failed') }}
                            {{ __('I Love Programming.') }}


                                @foreach($errors -> login -> all('<b>:message</b>') as $error)
                                    {!! $error !!}
                                @endforeach

                            {!! \Form::open(['url' => 'validations', 'files' => true, "method" => "post"]) !!}
                            {!! \Form::text('username', null, ['placeholder' => "Please enter username"]) !!}
                            {!! \Form::file('file') !!}
                            {!! \Form::submit('Please click here to submit') !!}
                            {!! \Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
