@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profiel</div>
                <div class="panel-body">
                @if (!isset($edit))
                @foreach ($profile as $profiel)
                  <div  style="text-transform:capitalize;">
                  <p>Naam: {{$profiel->name}}</p> 
                  <p>Email: {{$profiel->email}}</p>
                  </p>
                  </div>
              <a href="/profile/<?=$profiel->id?>/edit"> <button>Profiel aanpassen</button></a>                   
                  @endforeach
                  @else
                  @foreach ($profile as $profiel) 
                    {!!Form::open(['route' => ['profile.update', $profiel->id],'method' => 'put'])!!}
                    {!! Form::label('username', 'Naam: ') !!}
                    {!! Form::text('username', $profiel->name, ['required']) !!}<br>
                    {!! Form::label('email', 'E-Mail: ') !!}
                    {!! Form::email('email', $profiel->email) !!} <br>
                    {!!Form::submit('Opslaan')!!}
                    {!!Form::close()!!}
                  @endforeach
                 @endif   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
