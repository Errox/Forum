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
                        <table class="table table-hover">
                            <thead>
                              <th>Naam</th>
                              <th>Beschrijving</th>
                            </thead>
                            <tbody>
                                @foreach ($result[1] as $searched)
                                    <tr>
                                        <td><a href="/topic/<?=$searched->id?>">{{ $searched->topic_title}}</a></td>
                                        <td>{{ $searched->topic_description}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
