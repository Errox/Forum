@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    @foreach($result[0] as $topics)
                      <p>Deze leervraag is {{$topics->created_at->diffForHumans()}} gecreeerd. </p>
                      <h1>{{$topics->topic_title}}</h1>
                      <p>{{$topics->topic_description}}</p>
                      @foreach($topics->tag as $tag)
                      <span class="label label-primary" style="background-color:#8B0000;">{{$tag->tag_name}}</span>
                      @endforeach
                      <p>Gemaakt door <a  style="text-transform:capitalize;" href="/profile/<?=$topics->user->id?>">{{$topics->user->name}}</a></p>
                      @if(Auth::check())
                      <?php   $user = \Auth::user(); ?>
                        @if (!$result[2]->count())
                          {{Form::open(array('route' => array('subscribe.store'), 'method' => 'store')) }}
                          {{Form::hidden('id', $topics->id)}}
                          {{Form::submit('Aansluiten', ['class' => 'btn btn-primary'])}}
                          {{Form::close()}} 
                        @else
                          {{Form::open(array('route' => array('subscribe.destroy', $topics->id), 'method' => 'delete')) }}
                            <button class="btn btn-primary" type="submit" >Afmelden</button>
                          {{Form::close()}}
                          @endif
                      @if($topics->user_id == $user->id)
                        <br>
                   {!!Form::open(array('action' => array('TopicController@close'), 'method' => 'POST')) !!}
                   <input type="hidden" value="<?=$topics->user_id?>" name="user_id" />
                   <input type="hidden" value="<?=$topics->id?>" name="id" />  
                     <button class="btn btn-primary" type="submit">Vraag sluiten</button>
                   
                  {!!Form::close()!!}
                    @endif 
                    @endif                       
                    @endforeach
                      
                  </ul>
              </div>
          </div> 
          <div class="panel panel-default">
            <div class="panel-body">
              @if ($result[1]->count())
                @foreach($result[1] as $comments)
                  <div class="panel">
                    <h3>{{$comments->user->name}} antwoorde: </h3>
                    <h4>{{$comments->comment_description}} </h4>
                    <p>{{$comments->created_at->diffForHumans()}}</p>
                  </div>
                @endforeach
              @else
                <p>Er zijn nog geen antwoorden gegeven.</p>
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
                    {!! Form::textarea('comment_description', null, ['class' => 'form-control']) !!}
                      <br />
                    {!! Form::submit('Plaats antwoord', ['class' => 'btn btn-primary form-control']) !!}
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
