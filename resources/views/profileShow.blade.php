@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6 col-xs-offset-0 col-sm-offset-0 " >
      <div class="panel panel-info">
        <div class="panel-heading">
          @foreach ($profile as $profiel)
            <h3 class="panel-title">{{$profiel->name}}</h3>
        </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6 col-lg-12 " align="center"> <img alt="User Pic" src="https://eliaslealblog.files.wordpress.com/2014/03/user-200.png" class="img-circle img-responsive"> </div>
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Naam:</td>
                        <td>{{$profiel->name}}</td>
                      </tr>
                      <tr>
                        <td>Laatste geupdate:</td>
                        <td>{{$profiel->created_at->diffForHumans()}}</td>
                      </tr>

                        <td>Ov-nummer:</td>
                        <td>{{$profiel->ov_number}}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:{{$profiel->email}}">{{$profiel->email}}</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="panel-footer">
              <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
              @if(Auth::check())
                <?php $user = \Auth::user();?>
                @if ($user->id == $id)
                  <span class="pull-right">
                    <a href="<?=$user->id?>/edit" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                  </span>
                @endif
              @endif
            </div>
            @endforeach
            </div>
            </div>
            <div class="col-md-6  col-lg-6 panel-body" align="center">
                  <div class="panel">
                    <h3>About me</h3>
                    <br>
                  </div>
                <p>{!!$profiel->about!!}</p>
            </div>
          </div>

          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection