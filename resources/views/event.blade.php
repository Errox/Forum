@extends('layouts.app')

@section('content')
<div class="container col-md-12">
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}
</div>
@endsection
