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
                            {!! Form::text('description', null, ['class' => 'form-control', 'required']) !!}
                              <br />
                            {!! Form::label('room', 'Lokaal:') !!}
                            <select name="room" required>
                              @foreach($rooms as $room)
                                <option value="{{$room->id}}">{{$room->name}}</option>
                              @endforeach
                            </select>
                              <br />
                            <p>Datum: <input required type="text" name="time_0" id="datepicker"></p>
                            <p id="timeOnlyExample">Van: 
                              <input class="time start  ui-timepicker-input" id="basicExample" name="time_1" required> Tot: <input class="time end  ui-timepicker-input" id="basicExample1"  name="time_2" required>
                            </p>
                            {!! Form::submit('Plan afspraak', ['class' => 'btn btn-primary form-control']) !!}
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
    $( "#datepicker" ).datepicker({minDate: 0});
  });

  $('#timeOnlyExample .time').timepicker({
      'showDuration': true,
      'timeFormat': 'H:i', 
      'step': 15,
      'minTime': '8:00',
      'maxTime': '18:00'
  });

  var timeOnlyExampleEl = document.getElementById('timeOnlyExample');
  var timeOnlyDatepair = new Datepair(timeOnlyExampleEl);

</script>
@endsection