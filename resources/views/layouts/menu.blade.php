<body id="app-layout">
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <ul class="nav navbar-nav">
            <span><a href="{{ url('/tag')}}">Tags</a></span>
            <span>|</span>
            <span><a href="{{ url('/csv')}}">CSV</a></span>
            <span>|</span>
            <span><a href="{{url('/profile')}}">Gebruikers</a></span>
            <span>|</span>
            <span><a href="{{url('/result')}}">Overzicht Vragen</a></span>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
