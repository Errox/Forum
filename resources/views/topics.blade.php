@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                  <ul>

                  <table>
                  <thead>
                  <th>Naam</th>
                  <th>Beschrijving</th>
                  <th>Datum</th>
                  </thead>
                  <tbody>
                    @foreach($result as $topics)
                    <tr>
                        <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                        <td>{{ $topics->topic_description}}</td>
                        <td>{{$topics->created_at}}</td>
                        <td>Created by {{ $topics->name}} </td>
                    </tr>
                  	@endforeach
                    </tbody>
                    </table>
                    </div>
                  </ul>
            </div>
        </div>
    </div>
</div>
@endsection
