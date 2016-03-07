@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                @if (isset($result))

                    @if (empty($result))

                        <p>Sorry, we hebben geen resultaten gevonden</p>

                    @else    

                        @foreach ($result as $searched)

                            <p> {{$searched->topic_title}}</p>

                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
