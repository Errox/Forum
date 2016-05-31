@extends('layouts.app')
@section('content')

<div class="container col-md-12" <?php if($user->role != 1){ ?>style="display:none;"<?php } ?>>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">In Behandeling</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Tags</th>
                        <th>title</th>
                        <th>naam</th>
                        <th>Actie</th>
                      </thead>
                      <tbody id="behandeling">
                    </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
    <div class="container col-md-12">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Wachtrij<span style="float:right; text-align:right;" id="ticket"></span></div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Tags</th>
                        <th>title</th>
                        <th>naam</th>
                        @if($user->role == 1)<th>Actie</th>@endif
                      </thead>
                      <tbody id="open">
                    </tbody></table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog" title="Support ticket">
  <div class="panel panel-default">
    <div class="panel-body">
      <tbody>
        {!! Form::open(array('name' => 'Ticket', 'method' => 'POST'))!!}
          <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
            <div class="col-md-6">
              {!! Form::label('name', "tag 1")!!}
                <select id="tag1" name="tag1">
                  @foreach($tags as $tag)
                      <option name="objectid" value="{{$tag->id}}">{{$tag->tag_name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-md-6">
              {!! Form::label('name', "Tag 2")!!}
              <br> 
              <select id="tag2" name="tag2">
                @foreach($tags as $tag)
                  <option name="objectid" value="{{$tag->id}}">{{$tag->tag_name}}</option>
                @endforeach
              </select>
            </div>
              Algemeen probleem <input type="text" id="title" name="title" class="form-control"><br>
              <button onclick="submitdata()" type="button">Submit ticket</button>
                {!! Form::close()!!}
              </tbody>
            </table>
          </div>
        </div>
      </tbody>
    </div>
  </div>
</div>



<script>
  var refInterval = window.setInterval('update()', 1500);
  var actiefInterval = window.setInterval('actief()', 1500);
  var update = function() {
      $.ajax({
          type : 'GET',
          url : '/queue/ajax',
          success : InBehandeling});
  };
  update();

    var actief = function() {
      $.ajax({
          type : 'GET',
          url : '/queue/actief',
          success : checker});
  };
  actief();

  function checker(data){
    var result = data[0];
    var ticket = document.getElementById("ticket");
    
    ticket.innerHTML = '<button id="opener2">Creeeer ticket </button>';
    $( "#opener2" ).click(handleOpenerClick);
    if (result.active === 1){
          ticket.innerHTML = '<button id="cancel" onclick="cancelticket(<?=$user->id?>)">Cancel</button>';
    }
     
  }

  function InBehandeling(data){


  var loops = data.length;
  var open = document.getElementById("open");
  var behandelingen = document.getElementById("behandeling");
  behandelingen.innerHTML = "";
  open.innerHTML = "";
  //console.log(data[0].tag[0].tag_name);
    for (var i = 0; i < loops; i++){
      var total = -1
      var tags = "";

      total += data[i].tag.length;
      for (var t = 0; t <= total; t++){
        tags = tags+"<span class='label label-primary' style='background-color:#337ab7;'>" + data[i].tag[t].tag_name + "</span>  ";
      }
    
    if(data[i].status === 1){

    var   behandeling = '<?php if ($user->role == 1){?><tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<button class="btn btn-primary" onclick="statusupdate('+data[i].id+')">Afsluiten</button>' +'</td><?php } ?></tr><?php } ?>'; 
        
      // console.log(behandeling.length);
       
       behandelingen.innerHTML += behandeling;
     }

     if(data[i].status === 0){
    var   openingen = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<button class="btn btn-primary" onclick="statusupdate('+data[i].id+')">Behandelen</button>' +'</td><?php } ?></tr>'; 


        open.innerHTML += openingen;
       }  
     }
   }

var handleOpenerClick = function(e) {
  $( "#dialog" ).dialog( "open" );

}

$(function() {
    $( "#dialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 500
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    });

    //$( "#opener" ).click(handleOpenerClick);
});
  
function submitdata(){

  var tag1=document.getElementById( "tag1" );
  var tag2=document.getElementById( "tag2" );
  var title=document.getElementById( "title" );

  var token=document.getElementById( "token" );
  $.ajax({
          type: 'post',
          url: '/queue',
          data: {
          tag1:tag1.value,
          tag2:tag2.value,
          title:title.value,
          _token:token.value
          },
          success: function (response) {
            $( "#dialog" ).dialog( "close" );
           var ticket = document.getElementById("ticket");
          ticket.innerHTML = '<button id="cancel" onclick="cancelticket(<?=$user->id?>)">Cancel</button>';

          }
      });
  return false;
}

function cancelticket(id){
  $.ajax({
        type: 'get',
        url: '/queue/'+id+'/edit',
        data: {
        id:id,
        _token:token.value
        },
        success: function (response) {

        }
});
}

function statusupdate(data)
{
  var token=document.getElementById( "token" );
  $.ajax({
          type: 'patch',
          url: '/queue/'+data,
          data: {
          id:data,
          _token:token.value
          },
          success: function (response) {
         
          }
  });
  return false;
}
$('form input').on('keypress', function(e) {
    return e.which !== 13;
});

</script>
@endsection
