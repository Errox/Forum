@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                  <ul>
                  	@foreach($topic as $topics)
                  		<p>{{ $topics->id}}</p>
                  		<p>{{ $topics->user_id}}</p>                  	
                  		<p>{{ $topics->topic_title}}</p>
                  		<p>{{ $topics->topic_description}}</p>
                  		<p>{{ $topics->topic_tag}}</p>
                  		<p>--------------------------------------------</p>
                  	@endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
