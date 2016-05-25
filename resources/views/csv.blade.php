@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Leerlingen toevoegen met een csv bestand</div>
                  <div class="panel-body centerd">
                    <h1 style="color: red">ALLEEN CSV BESTANDEN</h1>
                    @if(isset($good))
                      <div class="alert alert-success">
                        <strong>Success!</strong> Alle gebruikers zijn succesvol geupload.
                      </div>
                    @endif
                      {{Form::open(array('url' => 'csv', 'files' => true, 'method' => 'post'))}}                      
                      {{Form::token()}}
                      {{Form::file('csv', array('accept' => '.csv'))}}
                      {{Form::submit('Uploaden')}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
