@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Topics</div>
                  <div class="panel-body">
                    <ul>
                      <table class="table table-hover table-striped">
                        <thead>
                          <th>Naam</th>
                          <th>Beschrijving</th>
                          <th>Datum</th>
                          <th>Created by</th>
                        </thead>
                        <tbody>
                          @foreach($result as $topics)
                          <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_description}}</a></td>
                              <td>{{ $topics->created_at}}</td>
                              <td>{{ $topics->User->name}} </td>
                          </tr>
                      	 @endforeach
                        </tbody>
                      </table>
                    </ul>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
