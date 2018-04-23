@extends('blade.default')

@section('sidebar_left')
    @parent
    This is from child side bar left
@show

@section('content')
    This is the body content {{ $delivery_status }} and {{{ $contact  }}}
@stop

@section('sidebar_right')
    @parent
    This is from child side bar right
@show