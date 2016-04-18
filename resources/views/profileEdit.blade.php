@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6 col-xs-offset-0 col-sm-offset-0  toppad" >
      <div class="panel panel-info">
            @foreach ($profile as $profiel) 
                <div class="panel-heading">Edit profiel van {{$profiel->name}}</div>
           		  <div class="panel-body">
            		<div class="row">
              			<div class="col-md-12 col-lg-12 " align="center"> <img alt="User Pic" src="https://eliaslealblog.files.wordpress.com/2014/03/user-200.png" class="img-circle img-responsive"> </div>
                		<div class=" col-md-12 col-lg-12 "> 
                  			<table class="table table-user-information">
	                    		<tbody>
	                    		{!!Form::open(['route' => ['profile.update', $profiel->id],'method' => 'put'])!!}
	                      			<tr>
	                        			<td>{!!Form::label('username', 'Naam: ') !!}</td>
	                        			<td>{!!Form::text('username', $profiel->name, ['required']) !!}</td>
	                      			</tr>
	                      			<tr>
				                        <td>Laatste geupdate:</td>
				                        <td>{{$profiel->created_at->diffForHumans()}}</td>
				                    </tr>
				                    <tr>
				                      <td>Date of Birth</td>
				                      <td>01/24/1988</td>
				                    </tr>
				                      <td>Ov-nummer:</td>
				                      <td>{{$profiel->ov_number}}</td>
				                    </tr>
				                    <tr>
				                      <td>{!!Form::label('email', 'E-Mail: ') !!}</td>
				                      <td>{!!Form::email('email', $profiel->email) !!} <br></td>
				                    </tr>
				                {!!Form::close()!!}    
	                    		</tbody>
                  			</table>
                		</div>
              		</div>
            	</div>
	            <div class="panel-footer">
	              @if(Auth::check())
	                <?php $user = \Auth::user();?>
	                @if ($user->id == $profiel->id)
                        {!!Form::submit('Opslaan', ['class' => 'btn btn-primary'])!!}
	                @endif
	              @endif
	            </div>
              </div>
            </div>
          @endforeach
        </div>
    </div>
</div>
@endsection
