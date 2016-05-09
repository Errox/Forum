@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                      <p>Deze leervraag is {{$result->created_at->diffForHumans()}} gecreeerd. </p>
                      <h1>{{$result->topic_title}}</h1>
                        {{Form::open(array('route' => array('topic.update', $result->id), 'method' => 'PATCH'))}}
                          <?php echo Form::textarea('description', $result->topic_description, ['class' => 'form-control']) ?>
                        {!! Form::submit('Aanpassen', ['class' => 'btn btn-primary form-control']) !!}
                      @foreach($result->tag as $tag)
                      <span class="label label-primary" style="background-color:#8B0000;">{{$tag->tag_name}}</span>
                      @endforeach
                        <p>Gemaakt door <a  style="text-transform:capitalize;" href="/profile/<?=$result->user->id?>">{{$result->user->name}}</a></p>
                      @if(Auth::check())
                        <?php   $user = \Auth::user(); ?>
                      @endif
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
