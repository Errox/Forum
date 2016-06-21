@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6 col-xs-offset-0 col-sm-offset-0  toppad" >
      <div class="panel panel-info">
            @foreach ($profile as $profiel) 
                <div class="panel-heading">Bewerk profiel van {{$profiel->name}}</div>
           		  <div class="panel-body">
            		<div class="row">
              			<div class="col-md-12 col-lg-12 " align="center"> <img alt="User Pic" src="https://eliaslealblog.files.wordpress.com/2014/03/user-200.png" class="img-circle img-responsive"> </div>
                		<div class=" col-md-12 col-lg-12 "> 
                  			<table class="table table-user-information">
	                    		<tbody>
	                    		{!!Form::open(['route' => ['profile.update', $profiel->id],'method' => 'put'])!!}
	                      			<tr>
	                        			<td>{!!Form::label('username', 'Naam: ') !!}</td>
	                        			<td>{!!Form::label('username', $profiel->name) !!}</td>
	                      			</tr>
	                      			<tr>
				                        <td>Laatste geupdate:</td>
				                        <td>{{$profiel->created_at->diffForHumans()}}</td>
				                    </tr>
				                      <td>Ov-nummer:</td>
				                      <td>{{$profiel->ov_number}}</td>
				                    </tr>
				                    <tr>
				                      <td>{!!Form::label('email', 'E-Mail: ') !!}</td>
				                      <td>{!!Form::email('email', $profiel->email) !!} <br></td>
				                    </tr>

				                    <tr>
				                    	<td>Toon email?</td>
				                    	<td><input type="checkbox" name="email_privacy" <?= ($privacy[0]->email_active == 1) ? 'checked' : ''; ?>></td>
				                    </tr>
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
              	<div class="col-md-6  col-lg-6 panel-body" align="center">
                  	<div class="panel">
                    	<h3>{!!Form::label('about', 'About me')!!}</h3>
                    	<br>
                  	</div>
                	<p>{!!Form::textarea('about', $profiel->about)!!}</p>
                	{!! Form::close() !!}
                <table>
                <tr>
			  	{!!Form::open(array('url' => 'profileChange')) !!}

				 	<td>{!!Form::label('Oud Wachtwoord: ')!!}
					{!!Form::password('passwordOld', null)!!}</td>    

				 	<td>{!!Form::label('Nieuw Wachtwoord: ')!!}
					{!!Form::password('passwordNew', null)!!}</td>    

					<td>{!!Form::submit('Wachtwoord opslaan', ['class' => 'btn btn-primary'])!!}</td>

				{!! Form::close()!!}
				</tr>
				</table>
            	</div>

          @endforeach
        </div>
    </div>
</div>
@endsection
