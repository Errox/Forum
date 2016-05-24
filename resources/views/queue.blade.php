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
                        <td>{{$queue->created_at->diffForHumans()}} </td>
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
                <div class="panel-heading">Wachtrij</div>
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



<script>
 var refInterval = window.setInterval('update()', 1500); // 30 seconds

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
  
    var   behandeling = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>'+ data[i].user.name +  '</td>'
        +'<td>' + data[i].status + '</td></tr>'; 
        
      // console.log(behandeling.length);
       
       behandelingen.innerHTML += behandeling;
     
       }  

}



</script>
@endsection
