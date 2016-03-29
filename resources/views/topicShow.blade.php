@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    @foreach($result[0] as $topics)
                      <p>{{$topics->created_at}} </p>
                      <h1>{{$topics->topic_title}}</h1>
                      <p>{{$topics->topic_description}}</p>
                      <p>Gemaakt door {{$topics->username}}</p>
                      @if(Auth::check())
                        @if (!$result[2]->count())
                          {{Form::open(array('route' => array('subscribe.store'), 'method' => 'store')) }}
                          {{Form::hidden('id', $topics->id)}}
                          {{Form::submit('Aansluiten', ['class' => 'btn btn-primary'])}}
                          {{Form::close()}} 
                        @else
                          {{Form::open(array('route' => array('subscribe.destroy', $topics->id), 'method' => 'delete')) }}
                            <button class="btn btn-primary" type="submit" >Afmelden</button>
                          {{Form::close()}}
                          @endif
                        @endif 
                    @endforeach
                  </ul>
              </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
              @if ($result[1]->count())
                @foreach($result[1] as $comments)
                  <div class="panel">
                    <h3>{{$comments->user->name}} antwoorde: </h3>
                    <h4>{{$comments->comment_description}} </h4>
                    <p>Tijd: {{$comments->created_at}}</p>
                  </div>
                @endforeach
              @else
                <p>Er zijn nog geen antwoorden gegeven.</p>
              @endif
            </div>
          </div>
         @if (Auth::check()) 
            <div class="panel panel-default">
              <div class="panel-body">
                {!! Form::open(array('url' => 'comment')) !!}
                  <div class="form-group">
                    {!! Form::label('description', 'Antwoord') !!}
                    {!! Form::hidden('id', $topics->id) !!}
                    {!! Form::textarea('comment_description', null, ['class' => 'form-control']) !!}
                      <br />
                    {!! Form::submit('Plaats antwoord', ['class' => 'btn btn-primary form-control']) !!}
                  </div>
                {!! form::close(); !!}
              </div>
              @else
              <h4 style="text-align : center;"><a href="/login">Log in om te reageren</a></h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
