@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    @foreach($result[0] as $topics)
                      <p>{{ $topics->created_at}} </p>
                      <h1> {{ $topics->topic_title}}</h1>
                      <p>{{ $topics->topic_description}}</p>
                        <br/>
                      <p>Created by {{ $topics->name}}</p>
                    @endforeach
                  </ul>
              </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
              @foreach($result[1] as $comments)
                <div class="panel">
                  <h3>{{$comments->name}} asked: </h3>
                  <h4>{{$comments->comment_description}} </h4>
                  <p>Time: {{$comments->created_at}}</p>
                </div>
              @endforeach
            </div>
          </div>
            <div class="panel panel-default">
              <div class="panel-body">
                {!! Form::open(array('url' => 'comment')) !!}
                  <div class="form-group">
                    {!! Form::label('description', 'Comment') !!}
                    {!! Form::textarea('comment_description', null, ['class' => 'form-control']) !!}
                      <br />
                    {!! Form::submit('Create comment', ['class' => 'btn btn-primary form-control']) !!}
                  </div>
                {!! form::close(); !!}
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
