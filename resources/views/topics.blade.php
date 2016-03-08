@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                  <ul>
                    @foreach($result as $topics)
                      <div class="panel-body panel">
                        <h1><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></h1>
                        <p>topic description: {{ $topics->topic_description}}</p>
                        <p>Created by {{ $topics->name}} </p>
                        <p>{{$topics->created_at}}</p>
                      </div>
                  	@endforeach
                  </ul>
            </div>
        </div>
    </div>
</div>
@endsection
