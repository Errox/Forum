@extends('layouts.app')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Notificaties</div>
                  <div class="panel-body">
                  <div class="">
                    <table class="table table-hover">
                      <thead>
                        <th>Beschrijving</th>
                        <th>Topic Title</th>
                      </thead>
                      <tbody>
                      @foreach($notifications as $notification)
                        <tr>
                          <td><a href="/profile/{{$notification->user->id}}">{{$notification->user->name}}</a> {{$notification->notification_description}}</td>
                          <td><a href="/topic/{{$notification->topic_id}}"> {{$notification->topic->topic_title}}</a></td>
                          <td>{{$notification->created_at->diffforhumans()}}</td>
                          <td>
                          @if($notification->read == '0')
                            <a href="/notificaties/{{$notification->id}}"><i class="fa fa-bookmark" aria-hidden="true"></a></i>
                          @else
                            <a href="/notificaties/{{$notification->id}}"><i class="fa fa-bookmark-o" aria-hidden="true"></a></i>
                          @endif
                        </tr>
                      @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
