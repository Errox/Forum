@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Beheer overzicht leervragen</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Titel</th>
                        <th>Beschrijving</th>
                        <th>tags</th>
                        <th>Gemaakt door</th>
                        <th>Status</th>
                      </thead>
                      <tbody>
                        @foreach($result[0] as $topics)
                          <?php
                          if ($topics->active == 1){
                            $status = "Actief";
                          }
                          else{
                            $status = "Gearchiveerd";
                          }?>
                          <tr>
                            <td>{{$topics->created_at->diffForHumans()}} </td>
                            <td><a href="topic/<?=$topics->id?>">{{str_limit($topics->topic_title, 45)}}</a></td>
                            <td>{{str_limit($topics->topic_description, 45)}}</td>
                            <td>
                              @foreach($topics->tag as $tag)
                               <span class="label label-primary">{{$tag->tag_name}}</span>
                              @endforeach
                            </td>
                            <td><a href="/profile/<?=$topics->user->id?>">{{$topics->user->name}}</a></td>
                            <td>{{$status}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
