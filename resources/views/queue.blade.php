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
                        <th>button hier</th>
                      </thead>
                      <tbody>
                      @foreach($queues as $queue)
                      @if($queue->status == '0')
                      <tr>
                          <td>
                          @foreach($queue->tag as $tag)
                           <span class="label label-primary">{{$tag->tag_name}}</span>
                          @endforeach
                          </td>
                        <td>{{str_limit($queue->title, 25 )}}</td>
                        <td>{{$queue->user->name}}</td>
                        <td>
                        @if($queue->status == '1')Idle
                        @elseif($queue->status == '0') In behandeling 
                        @else Onbekent
                        @endif 
                        </td>
                          <td>
                            <a href="#" class="btn btn-primary"> Hallo </a>
                          </td>
                      </tr>
                      @endif
                    @endforeach
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
                        <th>button hier</th>
                      </thead>

                      <tbody id="behandeling">

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
              <div class="col-md-6">
                {!! Form::label('name', "tag 1")!!}
                <form onsubmit="return makeSearch()" name="Ticket">
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
                  Algemeen probleem <input type="text" name="title" class="form-control"><br>
                <input type="submit" value="Submit">
                </form>
              </tbody>
            </table>
          </div>
        </div>



<script>
  var refInterval = window.setInterval('update()', 1000); // 1 seconds

  var update = function() {
      $.ajax({
          type : 'GET',
          url : '/queue/ajax',
          success : InBehandeling});
  };
  update();

  function InBehandeling(data){

    var loops = data.length;
    var behandelingen = document.getElementById("behandeling");
    behandelingen.innerHTML = "";
    //console.log(data[0].tag[0].tag_name);
    for (var i = 0; i < loops; i++){
      var total = -1
      var tags = "";
      total += data[i].tag.length;
      for (var t = 0; t <= total; t++){
        tags = tags+"<span class='label label-primary' style='background-color:#337ab7;'>" + data[i].tag[t].tag_name + "</span>  ";
      }
    console.log(tags);
    
    var behandeling = '<tr><td>' + data[i].created_at+'</td>'
          +'<td>' + tags + '</td>'
          +'<td>' + data[i].title + '</td>'
          +'<td>'+ data[i].user.name +  '</td>'
          +'<td>' + data[i].status + '</td></tr>';     
    // console.log(behandeling.length);
    behandelingen.innerHTML += behandeling;
       
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
alert("poop function");
var tag1=document.getElementById( "name_of_user" );
var tag2=document.getElementById( "age_of_user" );
var title=document.getElementById( "course_of_user" );

$.ajax({
        type: 'post',
        url: '',
        data: {
        tag1:tag1,
        tag2:tag2,
        title:title
        },
        success: function (response) {
          $('#success__para').html("You data will be saved");
        }
    });
return false;
}
</script>
@endsection
