<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Localghost</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Alle js bestanden die nodig zijn om de website succesvol te laten draaien wordt hier opgehaald. -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
     <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
     <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
     <script src="http://fullcalendar.io/js/fullcalendar-2.7.1/lang/nl.js"></script>
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
     <script type="text/javascript" src="http://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
     <script type="text/javascript" src="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
     <script type="text/javascript" src="http://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
     <link rel="stylesheet" href="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css"/>
     
     <!-- een google analystic script wordt hier uitgevoerd -->
     <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-77661336-1', 'auto');
        ga('send', 'pageview');
    </script>


    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        .quick-btn .label {
          position: absolute;
          top: -5px;
          right: -5px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Localghost
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
            <!-- check of de gebruiker is ingelogd of een guest is -->
            @if(Auth::guest())

            @else
            <!-- Drop down menu als de gebruiker is ingelogd.  -->
            <div class="dropdown nav navbar-nav">
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('/topic') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    <li><a href="{{url('/profile')}}"><i class="fa fa-users" aria-hidden="true"></i> Leerlingen</a></li>
                    <li><a href="{{url('/event')}}"><i class="fa fa-calendar" aria-hidden="true"></i> Agenda</a></li>     
                </ul>
              </li>
                 
            <li><a href="{{url('/queue')}}"> Direct hulp nodig?</a></li>      
            </div>
            @endif
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li style="margin-top: 10px;">
                    {!! Form::open(array('url' => 'search', 'required')) !!}
                        <div class="form-group" style="left: 100px;width:200px;">
                            {!! Form::text('Search', null, ['class' => 'form-control', 'placeholder' => 'Zoeken', 'required'] ) !!}
                        </div>
                    {!! Form::close() !!}
                    </li> 
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>

                    @else
                        <?php         
                             $user = \Auth::user();
                            $info =  DB::table('users')
                            ->where('id', '=', $user->id)
                            ->get(); 
                            foreach ($info as $result){
                                $role = $result->role;
                            } 
                        ?>
                    @if($role != 0)
                        <li><a href="{{ url('/beheer') }}">Beheer</a></li>
                    @endif
                    
                    <li><a href="{{ url('/topic/create')}}">Maak leervraag</a></li>

                    <?php         
                        $user = \Auth::user();
                            $count = DB::table('notifications')
                            ->where('receiver_id','=', $user->id)
                            ->where('read', '=', '0')
                            ->count();
                    ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ str_limit(Auth::user()->name, '20') }} 
                                @if($count == '0')
                                    <span class="label label-info" style="display:none;">{{$count}}</span> 
                                @else
                                    <span class="label label-info">{{$count}}</span>
                                @endif
                                    <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/profile/<?=$result->id?>"><i class="fa fa-btn fa-user"></i>Profiel</a></li>
                                <li><a href="{{ url('/notificaties') }}"><i class="fa fa-btn fa-bell"></i>Notificaties</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
        <!-- dit is een succes message die globaal aangeroepen kunnen worden met bepaalde text -->
        @if (Session::has('flash_message_succes'))
            <div class="container alert alert-success"> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('flash_message')}}</div>
        @endif
        <!-- dit is een alert message die globaal aangeroepen kunnen worden met bepaalde text -->
        @if (Session::has('flash_message_alert'))
            <div class="container alert alert-danger"> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('flash_message_alert')}}</div>
        @endif

    
    @yield('content')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
