@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div>
                    @foreach($result[0] as $topics)
                      <p>Deze leervraag is {{$topics->created_at->diffForHumans()}} gecreeerd.
                      @if(Auth::check())
                        <div style="display:inline-block;"> 
                          <?php   $user = \Auth::user(); ?>
                          @if (!$result[2]->count())
                            {{Form::open(array('route' => array('subscribe.store'), 'method' => 'store', 'style' => 'display:inline-block;')) }}
                            {{Form::hidden('id', $topics->id)}}
                            {{Form::submit('Aansluiten', ['class' => 'btn btn-primary', 'style' => 'display:inline-block;'])}}
                            {{Form::close()}} 
                          @else
                            {{Form::open(array('route' => array('subscribe.destroy', $topics->id), 'method' => 'delete','style' => 'margin-bottom : 5px;')) }}
                            <button class="btn btn-primary" type="submit" >Afmelden</button>
                            {{Form::close()}}
                          @endif

                        @if($topics->user_id == $user->id || $user->role == 1)
                          {!!Form::open(array('action' => array('TopicController@close'), 'method' => 'POST','style' => 'margin-bottom : 5px;', 'style' => 'display:inline-block;')) !!}
                          <input type="hidden" value="<?=$topics->user_id?>" name="user_id" />
                          <input type="hidden" value="<?=$topics->id?>" name="id" />  
                          <button class="btn btn-primary" type="submit">Vraag sluiten</button>
                          {!!Form::close()!!}
                        @endif
                        @if($user->role == 1 || $user->id == $topics->user_id)
                          <?php echo Form::open(array('url' => array('topic/'.$topics->id.'/edit'), 'method' => 'GET', 'style' => 'display:inline-block;')); ?>
                          <button class="btn btn-primary" type="submit">Vraag aanpassen</button>
                          {!!Form::close()!!}  
                            
                        @endif
                      @endif
                      </div>
                      </div>
                      <div style="margin-left:10px;">
                        <h1>{{$topics->topic_title}}</h1>
                        <p>{{$topics->topic_description}}</p>
                      @foreach($topics->tag as $tag)
                      <span class="label label-primary" style="background-color:#8B0000;">{{$tag->tag_name}}</span>
                      @endforeach
                      <p>Gemaakt door <a  style="text-transform:capitalize;" href="/profile/<?=$topics->user->id?>">{{str_limit($topics->user->name, '20')}}</a></p>
                      </div>
                    @endforeach 
                  </div>
              
          </div> 
          <div class="panel panel-default">
            <div class="panel-body">
              @if ($result[1]->count())
                @foreach($result[1] as $comments)
                  <div class="panel">
                    <h3>{{str_limit($comments->user->name,'20')}} antwoorde: </h3>
                    <h4>{{$comments->comment_description}} </h4>
                    <p>{{$comments->created_at->diffForHumans()}}</p>
                  </div>
                @endforeach
              @else
                <p style="text-align: center;">Er zijn nog geen antwoorden gegeven.</p>
              @endif
            </div>
          </div>
        @if (Auth::check()) 
          <div class="panel panel-default">
            <div class="panel-body">
              {!! Form::open(array('url' => 'comment')) !!}
                <div class="form-group">
                  {!! Form::label('description', 'Antwoord') !!}
                  {!! Form::hidden('id', $topics->id) !!}
                  <?php echo Form::textarea('comment_description', null, ($topics->active == 0 ? ['class' => 'form-control', 'disabled' => 'disabled'] : ['class' => 'form-control', 'required'])) ?>
                  <br />
                  {!! Form::submit('Plaats antwoord',($topics->active == 0 ? ['class' => 'btn btn-primary form-control', 'disabled' => 'disabled'] : ['class' => 'btn btn-primary form-control'])) !!}
                  </div>
                  {!! form::close(); !!}
                </div>
        @else
          <h4 style="text-align : center;"><a href="/login">Log in om te reageren</a></h4>
          </div>
        @endif
        </div>
    </div>
</div>
@endsection
