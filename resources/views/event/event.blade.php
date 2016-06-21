@extends('layouts.app')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Agenda<span style="float:right;">
                @if($user->role != '0')
                  <a href="/event/create">Maak een nieuwe afspraak</a></span></div>
                @endif 
                  <div class="panel-body">
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
