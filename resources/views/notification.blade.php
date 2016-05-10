@extends('layouts.app')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Notificaties</div>
                  <div class="panel-body">
                  <div class="">
                  @if(count($notifications))
                    <table class="table table-hover">
                      <thead>
                        <th>Beschrijving</th>
                        <th>Door</th>
                        <th>Topic Title</th>
                      </thead>
                      <tbody>
                      @foreach($notifications as $notification)
                        <tr>
                          <td> {{$notification->notification_description}}</td>
                          <td><a href="/profile/{{$notification->user->id}}">{{$notification->user->name}}</a></td>
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
                      </tbody>
                    </table>
                  @else
                  <h2 style="text-align: center"> Er zijn nog geen notificaties.</h2>
                  @endif
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
