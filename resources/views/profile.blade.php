@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profiel</div>
                <div class="panel-body">
                @if (isset($show))
                @foreach ($profile as $profiel)
                  <div>
                  <p style="text-transform:capitalize;">Naam: {{$profiel->name}}</p> 
                  <p>Email: {{$profiel->email}}</p>
                  </p>
                  </div>
<?php
                    if ($user->id == $id){


          ?>    <a class="btn btn-primary" href="/profile/<?=$profiel->id?>/edit">Profiel aanpassen</a>
                                
             <?php  }      ?>                
                  @endforeach
                  @elseif(isset($index))
                  <table class="table table-hover table-striped">
                  <thead>
                    <th>Student</th>
                    @if(isset($user))
                   @if($user->role == 1) 
                    <th>Email</th>
                    @endif
                    @endif
                    <th>OV-nummer</th>
                  </thead>
                  <tbody>
                  @foreach($profile as $profiel)
                  <tr>
                  <td style="text-transform:capitalize;"><a href="/profile/<?=$profiel->id?>"><?=$profiel->name?></a></td>
                  @if(isset($user))
                  @if($user->role == 1)
                  <td><?=$profiel->email?></td>
                  @endif
                  @endif
                  <td><?=$profiel->ov_number?></td>
                  </tr>
                  @endforeach
                  </tbody>
                  </table>
                  @elseif(isset($edit))
                  @foreach ($profile as $profiel) 
                    {!!Form::open(['route' => ['profile.update', $profiel->id],'method' => 'put'])!!}
                    {!! Form::label('username', 'Naam: ') !!}
                    {!! Form::text('username', $profiel->name, ['required']) !!}<br>
                    {!! Form::label('email', 'E-Mail: ') !!}
                    {!! Form::email('email', $profiel->email) !!} <br>
                    {!!Form::submit('Opslaan', ['class' => 'btn btn-primary'])!!}
                    {!!Form::close()!!}
                  @endforeach
                 @endif   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
