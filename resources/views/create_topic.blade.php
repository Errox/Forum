@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! Form::open(array('url' => 'topic')) !!}
                        <div class="form-group">
                        @if ((session()->has('error')))
                            <p style="color:red;">Er moet een checkbox aangevinkt zijn!</p>
                        @endif
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('title', null, ['class' => 'form-control']) !!}
                             <br />
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                             <br />
                             {!! Form::label('tags', 'Tags:') !!}
                            <div class="topic_tags" style="overflow-y:scroll;height:100px;">
                                @foreach($tags as $tag)
                                    <input type="checkbox" name="tags[]" value="<?= $tag->id?>"> <?=$tag->tag_name?> <br>
                                @endforeach
                            </div>
                              <br />
                            {!! Form::submit('Create post', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
