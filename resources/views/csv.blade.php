@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body centerd">
                    <h1 style="color: red">ALLEEN CSV BESTANDEN</h1>
                      {{Form::open(array('url' => 'csv', 'files' => true, 'method' => 'post'))}}                      
                      {{Form::token()}}
                      {{Form::file('.csv')}}
                      {{Form::submit('Click Me!')}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
