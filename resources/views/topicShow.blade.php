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
                      <p>id: {{ $topics->id}} </a></p>
                      <p>user id: {{ $topics->name}}</p>                   
                      <p>topic title: {{ $topics->topic_title}}</p>
                      <p>topic description: {{ $topics->topic_description}}</p>
                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
