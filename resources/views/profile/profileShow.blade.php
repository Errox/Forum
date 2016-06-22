@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6 col-xs-offset-0 col-sm-offset-0 " >
      <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{{$profile->name}}</h3>
        </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6 col-lg-12 " align="center"> <img alt="User Pic" src="https://eliaslealblog.files.wordpress.com/2014/03/user-200.png" class="img-circle img-responsive"> </div>
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Naam:</td>
                        <td>{{$profile->name}}</td>
                      </tr>
                      <tr>
                        <td>Laatste geupdate:</td>
                        <td>{{$profile->created_at->diffForHumans()}}</td>
                      </tr>
                        <td>Ov-nummer:</td>
                        <td>{{$profile->ov_number}}</td>
                      </tr>
                      @if($privacy[0]->email_active == 1)
                        <tr>
                          <td>Email</td>
                          <td><a href="mailto:{{$profile->email}}">{{$profile->email}}</a></td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="panel-footer">
              @if(Auth::check())
                <?php $user = \Auth::user();?>
                @if ($user->id == $id)
                    <a href="<?=$user->id?>/edit" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                @endif
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6  col-lg-6 panel-body" align="center">
          <div class="panel">
            <h3>About me</h3>
            <br>
          </div>
          <p>{{$profile->about}}</p>
        </div>
      </div>
    </div>
@endsection