@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen<span style="float:right;"><a href="/event/create">Maak een nieuwe afspraak</a></span></div>
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
