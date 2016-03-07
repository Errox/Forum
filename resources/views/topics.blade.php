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
                  		<p>topic id: {{ $topics->id}}</p>
                  		<p>user id: {{ $topics->user_id}}</p>                  	
                  		<p> <a href="/topic/<?=$topics->id?>" >topic title: {{ $topics->topic_title}}</a></p>
                  		<p>topic description: {{ $topics->topic_description}}</p>
                  		<p>topic tags: {{ $topics->topic_tag}}</p>
                  		<p>--------------------------------------------</p>
                  	@endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
