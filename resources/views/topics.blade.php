@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body">
                    <table class="table table-hover table-striped">
                      <thead>
                        <th>Onderwerp</th>
                        <th>Beschrijving</th>
                        <th>Datum</th>
                        <th>Aanmeldingen</th>
                      </thead>
                      <tbody>
                        @foreach($result[0] as $topics)
                            <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td>{{ $topics->topic_description}}</td>
                              <td>{{ $topics->created_at}}</td>
                                <?php $subs = $topics->subscriptionsCount->first() ?>
                              <td>{{ $subs['aggregate'] }} </td>
                            </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Populaire Leervragen</div>
                  <div class="panel-body">
                    <table class="table table-hover table-striped">
                      <thead>
                        <th>Onderwerp</th>
                        <th>Beschrijving</th>
                        <th>Datum</th>
                        <th>Aanmeldingen</th>
                      </thead>
                      <tbody>
                        @foreach($result[1] as $topics)
                            <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td>{{ $topics->topic_description}}</td>
                              <td>{{ $topics->created_at}}</td>
                                <?php $subs = $topics->subscriptionsCount->first() ?>
                              <td>{{ $subs['aggregate'] }} </td>
                            </tr>
                       @endforeach
                      </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
