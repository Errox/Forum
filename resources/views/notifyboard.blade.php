@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>id</th>
                        <th>user_id</th>
                        <th>topic_id</th>
                        <th>notification_description</th>
                        <th>read</th>
                      </thead>
                      <tbody>
                      @foreach($notifications as $notification)
                      <tr>
                        <td>{{$notification->id}} </td>
                        <td>{{$notification->user_id}} </td>
                        <td>{{$notification->topic_id}} </td>
                        <td>{{$notification->notification_description}} </td>
                        <td>{{$notification->read}} </td>
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
