@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Leervragen</div>
                  <div class="panel-body">
                    <ul>
                      <table class="table table-hover table-striped">
                        <thead>
                          <th>Onderwerp</th>
                          <th>Beschrijving</th>
                          <th>Datum</th>
                          @if (isset($result[4]))
                          <th>Aansluiting</th>
                          @endif
                        </thead>
                        <tbody>
                          @foreach($result[0] as $topics)
                          <?php $subscribed = false; ?>
                          <tr>
                              <td><a href="/topic/<?=$topics->id?>">{{ $topics->topic_title}}</a></td>
                              <td>{{ $topics->topic_description}}</td>
                              <td>{{ $topics->created_at}}</td>
                            @if (isset($result[4]))  
                            @foreach($result[3] as $subscriptions)
                              @if($subscriptions->topic_id == $topics->id and $subscriptions->user_id == $result[4])
                                <?php $subscribed = true; ?>
                                @endif
                            @endforeach
                            @if ($subscribed == true)
                               <td> <span class="glyphicon glyphicon-star" aria-hidden="true"></span></td>
                              @else                  
                              <td>  <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>    </td>                     
                              @endif 
                              @endif
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
