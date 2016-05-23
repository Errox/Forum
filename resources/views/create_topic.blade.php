@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Maak een nieuwe leervraag</div>
                    <div class="panel-body">
                    {!! Form::open(array('url' => 'topic')) !!}
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
                                    <input type="checkbox" name="tags[]" value="<?= $tag->id?>" required> <?=$tag->tag_name?> <br>
                                @endforeach
                            </div>
                              <br />
                            {!! Form::submit('Maak leervraag', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection