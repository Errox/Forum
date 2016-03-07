@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                  <ul>

                    @foreach($result as $topics)
                      <h1> {{ $topics->topic_title}}</h1>
                      <p>{{ $topics->topic_description}}</p>
                      <p>Created by {{ $topics->name}}</p>                   

                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
