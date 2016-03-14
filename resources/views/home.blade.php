@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        @if (isset($result))
                            @if (empty($result) OR $result[0] == 0)
                                <p>Sorry, we hebben geen resultaten gevonden</p>
                            @else    
                                @foreach ($result[1] as $searched)
                                    <p> <a href="/topic/<?=$searched->id?>" > {{$searched->topic_title}}</a></p> 
                                    <p> --------------------------</p> 
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
