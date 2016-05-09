@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body">
                  <div class="">
                    <table class="table table-hover">
                      <thead>
                        <th>notification_description</th>
                        <th>user_id</th>
                        <th>Topic Title</th>
                        <th>read</th>
                        <th></th>
                      </thead>
                      <tbody>
                      @foreach($notifications as $notification)
                        <tr>
                          <td><a href="/notificaties/{{$notification->id}}">{{$notification->notification_description}}</a></td>
                          <td><a href="/profile/{{$notification->user->id}}">{{$notification->user->name}}</a> </td>
                          <td><a href="/topic/{{$notification->topic_id}}"> {{$notification->topic->topic_title}}</a></td>
                          <td>{{$notification->read}} </td>
                          <td>{{$notification->created_at->diffforhumans()}}</td>
                        </tr>
                      @endforeach
                  </div>
                </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <h2>Dit is een lijst met alle leervragen</h2>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
