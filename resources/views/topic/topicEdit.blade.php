@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                  <ul>
                    @if(isset($error))
                      <p style="color:red;">Er moet een checkbox aangevinkt zijn!</p>
                    @endif        
                      <p>Deze leervraag is {{$result->created_at->diffForHumans()}} gemaakt. </p>
                        {{Form::open(array('route' => array('topic.update', $result->id), 'method' => 'PATCH','onsubmit' => 'return validateForm();'))}}
                         {{ Form::text('title', $result->topic_title, ['class' => 'form-control', 'required']) }}
                          <?php echo Form::textarea('description', $result->topic_description, ['class' => 'form-control', 'required']) ?>
                            @if($user->role == 1)
                           <input type="checkbox" name="notify"> Verstuur notificatie?<br>
                           @endif
                       <p><strong>Tags</strong></p>
                        <div class="topic_tags" style="overflow-y:scroll;height:100px;">
                          @foreach($tags as $tag)    
                              <input type="checkbox" name="new_tags[]" value="<?= $tag->id?>">{{$tag->tag_name}}<br>
                          @endforeach
                         </div>
                      <p></p>                         
                        {!! Form::submit('Aanpassen', ['class' => 'btn btn-primary form-control']) !!}
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
<script>
  function validateForm(){
    var test = document.getElementsByName("new_tags[]").length;
    var test2 = document.getElementsByName("new_tags[]");
    var count = 0;
    
    for(var i = 0; i < test; i++){
      var nieuw = test2[count].checked;
      var array =  nieuw;
      if (array == true){
        var proceed = true;
      }
      count += 1;
    }
    if (proceed == true){
      return true;
    }
    else{
      alert("Kies minimaal 1 tag!");
      return false;
    }
  }
</script>