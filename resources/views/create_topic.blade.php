@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Maak een nieuwe leervraag</div>                       
                    <div class="panel-body">
                    {!! Form::open(array('url' => 'topic', 'name' => 'submitform', 'onsubmit' => 'return validateForm();')) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Titel:') !!}
                            {!! Form::text('topic_title', null, ['class' => 'form-control', 'required']) !!}
                             <br />
                            {!! Form::label('description', 'Beschrijving:') !!}
                            {!! Form::textarea('topic_description', null, ['class' => 'form-control', 'required']) !!}
                             <br />
                             {!! Form::label('tags', 'Tags:') !!}
                            <div class="topic_tags" style="overflow-y:scroll;height:150px;">
                                @foreach($tags as $tag)
                                    <input type="checkbox" name="tags[]" id="<?=$tag->id?>" value="<?= $tag->id?>"> <?=$tag->tag_name?> <br>
                                @endforeach
                            </div>
                              <br />
                              <span id="submit">
                            {!! Form::submit('Maak leervraag', ['class' => 'btn btn-primary form-control']) !!}
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script>
function validateForm(){
 var test = document.getElementsByName("tags[]").length;
 var test2 = document.getElementsByName("tags[]");
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