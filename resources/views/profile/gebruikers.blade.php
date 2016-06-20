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
                          <th>Account</th>
                          <th>Email</th>
                          <th>OV-nummer</th>
                          <th>Rol</th>
                        </thead>
                        <tbody>
                        @foreach($profile as $profiel)
                          <?php if ($profiel->role == 1){
                            $role = 'Leeraar';
                          }
                          else{
                            $role = 'Leerling';
                          } ?>
                          <tr>
                            <td style="text-transform:capitalize;"><a href="/profile/<?=$profiel->id?>">{{$profiel->name}}</a></td>
                            <td>{{$profiel->email}}</td> 
                            <td>{{$profiel->ov_number}}</td>
                            <td><a href="/beheer/<?=$profiel->id?>">{{$role}}</a></td>
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
