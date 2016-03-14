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
                      <p>Created by {{ $topics->name}}</p>

                      @if (empty($result[2]))
                        {{ Form::open(array('route' => array('subscribe.store'), 'method' => 'store')) }}
                        {{Form::hidden('id', $topics->id)}}
                        {{Form::submit('Subscribe', ['class' => 'btn btn-primary'])}}
                        {{ Form::close() }}
                      @else
                        {{ Form::open(array('route' => array('subscribe.destroy', $topics->id), 'method' => 'delete')) }}
                          <button class="btn btn-primary" type="submit" >Unsubscribe</button>
                        {{ Form::close() }}
                      @endif                  
                    @endforeach
                  </ul>
              </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
              @if (!empty($result[1]))
                @foreach($result[1] as $comments)
                  <div class="panel">
                    <h3>{{$comments->name}} replied: </h3>
                    <h4>{{$comments->comment_description}} </h4>
                    <p>Time: {{$comments->created_at}}</p>
                  </div>
                @endforeach
              @else
                <p>There are no comments on this topic. Be the first one to help out!</p>
              @endif
            </div>
          </div>
            <div class="panel panel-default">
              <div class="panel-body">
                {!! Form::open(array('url' => 'comment')) !!}
                  <div class="form-group">
                    {!! Form::label('description', 'Comment') !!}
                    {!! Form::hidden('id', $topics->id) !!}
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
