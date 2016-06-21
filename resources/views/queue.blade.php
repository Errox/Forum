@extends('layouts.app')
@section('content')


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
                      </thead>
                      <tbody id="open">
                    </tbody></table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog_comment" title="Comment">
  <div class="panel panel-default">
    <div class="panel-body">
      <tbody>
        {!! Form::open(array('name' => 'Comments', 'method' => 'STORE'))!!}
          <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">
                <div class="col-md-12">
                  {!! Form::label('Comment')!!}
                  <br> 

                </div>
                {{Form::textarea('comment', null,['class' => 'form-control', 'id' => 'comment'])}}
                {!! Form::label('name', "teacher")!!}
                <select id="teacher" name="teacher">
                  @foreach($teachers as $teacher)
                      <option name="objectid" value="{{$teacher->id}}">{{$teacher->name}}</option>
                  @endforeach
                </select>
              <span id="commentbutton"></span>

            </div>
                {!! Form::close()!!}
              </tbody>
            </table>
          </div>
        </div>
      </tbody>
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
              {!! Form::label('name', "Tag 1")!!}
                <select id="tag1" name="tag1">
                  @foreach($tags as $tag)
                    @if($tag->active == 1)
                      <option name="objectid" value="{{$tag->id}}">{{$tag->tag_name}}</option>
                    @endif
                  @endforeach
                </select>
                </div>
                <div class="col-md-6">
                  {!! Form::label('name', "Tag 2")!!}
                  <br> 
                  <select id="tag2" name="tag2">
                        <option name="objectid" value="null"></option>
                    @foreach($tags as $tag)
                      @if($tag->active == 1)
                        <option name="objectid" value="{{$tag->id}}">{{$tag->tag_name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                  Algemeen probleem <input type="text" id="title" name="title" class="form-control"><br>
                <button onclick="checkForm(); submitdata()" type="button" id="sendButton">Submit ticket</button>

            </div>
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
 // var refInterval = window.setInterval('update()', 500);
  var actiefInterval = window.setInterval('actief()', 500);


  var update = function() {
    $.ajax({
      type : 'GET',
      url : '/queue/ajax',
      success : InBehandeling});
  };
//  update();

  var actief = function() {
    $.ajax({
      type : 'GET',
      url : '/queue/actief',
      success : checker});
  };
  
  update();


  function checker(data){
    var result = data[0];
    var ticket = document.getElementById("ticket");
    
    ticket.innerHTML = '<button id="opener2">Nieuw probleem</button>';
    $( "#opener2" ).click(handleOpenerClick);
    if (result.active === 1){
          ticket.innerHTML = '<button id="cancel" onclick="cancelticket(<?=$user->id?>)">Cancel</button>';
    }
  



  }

  function InBehandeling(data){
    var id = data.userid;
    var role = data.role;
    data = data.queues;
    <?php $check = false; ?>
    var loops = data.length;
    var open = document.getElementById("open");
    

    open.innerHTML = "";
    //console.log(data[0].tag[0].tag_name);
      for (var i = 0; i < loops; i++){
        var total = -1
        var tags = "";

        total += data[i].tag.length;
        for (var t = 0; t <= total; t++){
          tags = tags+"<span class='label label-primary' style='background-color:#337ab7;'>" + data[i].tag[t].tag_name + "</span>  ";
        }



          var   openingen = '<tr><td>' + data[i].created_at+'</td>'
            +'<td>' + tags + '</td>'
            +'<td>' + data[i].title + '</td>'
            +'<td>' + data[i].user.name +  '</td>';
            if(data[i].user_id === id && data[i].status === 0 || role > 1 && data[i].status === 0){
              openingen = openingen + '<td> <button class="btn btn-primary" onclick="statusupdate('+data[i].id+')">Behandelen</button></td>';
            }

            if(data[i].status === 1){
              openingen = openingen + '<td> <button class="btn btn-primary" onclick="commentbox('+data[i].id+')">Afsluiten</button></td>';
            }

          openingen = openingen + '</tr>';
            open.innerHTML += openingen;
        
      }
   
   setTimeout(function(){
        update();
   },500);
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
var handleOpenerClick2 = function(e) {
  $( "#dialog_comment" ).dialog( "open" );

}

$(function() {
    $( "#dialog_comment" ).dialog({
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

   return true;
});

function submitcomment(data){
var disabled=document.getElementById("sendButton")
var comment=document.getElementById( "comment" );
var token=document.getElementById( "token" );
var teacher = document.getElementById("teacher");
$.ajax({
        type: 'POST',
        url: '/queue/postcomment',
        data: {
        comment:comment.value,
        teacher:teacher.value,
        id:data,
        _token:token.value
        },
        success: function (response) {
          statusupdate(data);
          $( "#dialog_comment" ).dialog( "close" );
        disabled.disabled = false;
        }
    });
return false;

}

function submitdata(data)
{
var disabled=document.getElementById("sendButton")
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
        disabled.disabled = false;
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

function commentbox(data){
  $( "#dialog_comment" ).dialog( "open" );
  var response = document.getElementById( "comment" );
  var button = document.getElementById("commentbutton");
  button.innerHTML = ' <button onclick="checkForm(); submitcomment('+data+')" type="button" id="sendButton">Submit comment</button>';
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


function checkForm()
  {
var disable =  document.getElementById('sendButton');
   disable.disabled = true;
}
$('form input').on('keypress', function(e) {
    return e.which !== 13;
});

</script>
@endsection
