@include('blade.sidebar_left');
@section('trial_section')
    @parent
    This is child trial
@stop
@section('content')
    This is content
@show
{{-- or stop --}}
This is not going to be printed
@include('blade.sidebar_right');