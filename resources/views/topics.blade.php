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
                          <?php $subscribed = false; ?>
                            <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td>{{ $topics->topic_description}}</td>
                              <td>{{ $topics->created_at}}</td>
                                <?php $subs = $topics->subscriptionsCount->first() ?>
                              <td class="text-center">
                                @if($subs == null)
                                  {{'0'}}
                                @else
                                  {{$subs['aggregate']}}
                                @endif
                              </td>
                                @if (isset($result[4]))  
                                  @foreach($result[3] as $subscriptions)
                                    @if($subscriptions->topic_id == $topics->id and $subscriptions->user_id == $result[4])
                                      <?php $subscribed = true; ?>
                                    @endif
                                  @endforeach
                                  @if ($subscribed == true)
                                    <td><span class="glyphicon glyphicon-star" aria-hidden="true"></span> </td>
                                  @else                  
                                    <td><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></td>                     
                                  @endif 
                                @endif
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
                          <?php $subscribed = false; ?>
                            <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td>{{ $topics->topic_description}}</td>
                              <td>{{ $topics->created_at}}</td>
                              <?php $subs = $topics->subscriptionsCount->first() ?>
                              <td class="text-center">
                                @if($subs == null)
                                  {{'0'}}
                                @else
                                  {{$subs['aggregate']}}
                                @endif
                              </td>
                                @if (isset($result[4]))  
                                  @foreach($result[3] as $subscriptions)
                                    @if($subscriptions->topic_id == $topics->id and $subscriptions->user_id == $result[4])
                                      <?php $subscribed = true; ?>
                                    @endif
                                  @endforeach
                                  @if ($subscribed == true)
                                    <td><span class="glyphicon glyphicon-star" aria-hidden="true"></span> </td>
                                  @else                  
                                    <td><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></td>                     
                                  @endif 
                                @endif
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
