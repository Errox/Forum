@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profiel</div>
                  <div class="panel-body">
                      <table class="table table-hover table-striped">
                        <thead>
                          <th>Student</th>
                          <th>OV-nummer</th>
                        </thead>
                        <tbody>
                        @foreach($profile as $profiel)
                          <tr>
                            <td style="text-transform:capitalize;"><a href="/profile/<?=$profiel->id?>">{{str_limit($profiel->name, '20')}}</a></td>
                            <td>{{$profiel->ov_number}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
