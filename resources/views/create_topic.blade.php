@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Maak een nieuwe leervraag</div>
                      @if(isset($error))
                            <p style="color:red;">Er moet een checkbox aangevinkt zijn!</p>
                    {!! Form::open(array('url' => 'topic', 'name' => 'submitform')) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Titel:') !!}
                            {!! Form::text('topic_title', $new_title, ['class' => 'form-control', 'required']) !!}
                             <br />
                            {!! Form::label('description', 'Beschrijving:') !!}
                            {!! Form::textarea('topic_description', $new_description, ['class' => 'form-control', 'required']) !!}
                             <br />
                             {!! Form::label('tags', 'Tags:') !!}
                            <div class="topic_tags" style="overflow-y:scroll;height:100px;">
                                @foreach($tags as $tag)
                                    <input type="checkbox" name="tags" id="<?=$tag->id?>" value="<?= $tag->id?>" onclick="validateForm(this)"> <?=$tag->tag_name?> <br>
                                @endforeach
                            </div>
                              <br />
                              <span id="submit">
                            {!! Form::submit('Maak leervraag', ['class' => 'btn btn-primary form-control']) !!}
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
                @else
                       
                    <div class="panel-body">
                    {!! Form::open(array('url' => 'topic', 'name' => 'submitform')) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Titel:') !!}
                            {!! Form::text('topic_title', null, ['class' => 'form-control', 'required']) !!}
                             <br />
                            {!! Form::label('description', 'Beschrijving:') !!}
                            {!! Form::textarea('topic_description', null, ['class' => 'form-control', 'required']) !!}
                             <br />
                             {!! Form::label('tags', 'Tags:') !!}
                            <div class="topic_tags" style="overflow-y:scroll;height:100px;">
                                @foreach($tags as $tag)
                                    <input type="checkbox" name="tags" id="<?=$tag->id?>" value="<?= $tag->id?>" onclick="validateForm(this)"> <?=$tag->tag_name?> <br>
                                @endforeach
                            </div>
                              <br />
                              <span id="submit">
                            {!! Form::submit('Maak leervraag', ['class' => 'btn btn-primary form-control']) !!}
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
                @endif 
            </div>
        </div>
    </div>
</div>


@endsection