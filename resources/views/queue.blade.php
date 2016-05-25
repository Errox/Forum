@extends('layouts.app')
@section('content')
<div class="container col-md-12">
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
                        <th>Status</th>
                       @if($user->role == 1)  <th>button hier</th>@endif
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
                <div class="panel-heading">Wachtrij<span style="float:right; text-align:right;"><button id="opener">Creeeer ticket </button></span></div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Tags</th>
                        <th>title</th>
                        <th>naam</th>
                        <th>Status</th>
                        @if($user->role == 1)<th>button hier</th>@endif
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
  var refInterval = window.setInterval('update()', 1500); // 1 seconds

  var update = function() {
      $.ajax({
          type : 'GET',
          url : '/queue/ajax',
          success : InBehandeling});
  };
  update();

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

    var   behandeling = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<td>' + data[i].status + '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<a class="btn btn-primary" href="/queue/'+data[i].id+'">Afsluiten</a>' +'</td><?php } ?></tr>'; 
        
      // console.log(behandeling.length);
       
       behandelingen.innerHTML += behandeling;
     }

     if(data[i].status === 0){
    var   openingen = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<td>' + data[i].status + '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<a class="btn btn-primary" href="/queue/'+data[i].id+'">Behandelen</a>' +'</td><?php } ?></tr>'; 


        open.innerHTML += openingen;
       }  
     }
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
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
  });
  
function submitdata()
{

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
        }
    });
return false;
}
</script>
@endsection
