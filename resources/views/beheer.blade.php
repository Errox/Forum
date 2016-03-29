@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
        <div class="container">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
         <ul class="nav navbar-nav">
            <span><a href="{{ url('/tag')}}">Tags</a></span>
          </ul>
        </div>
            </div>
              </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
 
            </div>
          </div>

        </div>
    </div>
</div>

@endsection
