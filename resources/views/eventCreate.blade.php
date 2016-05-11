@extends('layouts.app')
@extends('layouts.menu')
@section('content')

<div class="container col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Maak een nieuwe afspraak</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      {!! Form::open(array('url' => 'event')) !!}
                          <div class="form-group">
                            {!! Form::label('description', 'Beschrijving:') !!}
                            {!! Form::text('description', null, ['class' => 'form-control']) !!}
                              <br />
                            {!! Form::label('room', 'Lokaal:') !!}
                            <select name="room">
                              @foreach($rooms as $room)
                                <option value="{{$room->id}}">{{$room->name}}</option>
                              @endforeach
                            </select>
                              <br />
                            <p>Datum: <input type="text" name="time_0" id="datepicker"></p>
                            <p>Van: <input type="time" name="time_1"> Tot: <input type="time" name="time_2"></p>
                            {!! Form::submit('Maak leervraag', ['class' => 'btn btn-primary form-control']) !!}
                          </div>
                      {!! Form::close() !!}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
</script>
@endsection
